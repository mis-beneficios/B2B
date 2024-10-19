<?php

namespace App\Http\Controllers;

use App\Contrato;
use App\Helpers\ComisionesHelper;
use App\Helpers\LogHelper;
use App\Helpers\PagosHelper;
use App\Pago;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public $pagos_por_contrato = 24;
    private $log;

    public function __construct()
    {
        $this->middleware('auth');
        $this->pagos      = new PagosHelper;
        $this->log        = new LogHelper;
        $this->comisiones = new ComisionesHelper;
    }

    /**
     * Autor:    Diego Enrique Sanchez
     * Creado:   2023-04-04
     * Accion:   Validacion del formulario de edicion de segmento, tipo de datos ingresados por el usuario
     * @param    $request
     * @return   response
     */
    public function validar_form(Request $request, $id = null)
    {

        $validator = \Validator::make($request->all(), [
            'cantidad' => 'required|numeric|min:0',
            'segmento' => ($request->segmento) ? 'required|numeric|min:0' : '',
        ]);

        return $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-08
     * Almancenamos los pagos calculados.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $seg = count($request->segmento);

            $contrato = Contrato::findOrFail($request->contrato_id);

            foreach ($request->fecha_de_cobro as $key => $v) {
                Pago::updateOrCreate(
                    [
                        'estatus'     => 'Por Pagar',
                        'segmento'    => $request->segmento[$key],
                        'contrato_id' => $contrato->id,
                    ],
                    [
                        'contrato_id'    => $contrato->id,
                        'segmento'       => $request->segmento[$key],
                        'estatus'        => "Por Pagar",
                        'fecha_de_cobro' => $v,
                        'cantidad'       => $request->cantidad[$key],
                        'concepto'       => ($request->concepto[$key] == null) ? '' : $request->concepto[$key],
                    ]
                );
            }

            /**
             * Eliminamos los segmenros restantes si el numero de sergmentos fue modificado a menor al que se tenia guardado
             */
            try {
                if ($request->segmento[0] === "0") {

                    //Si el primer segmento corresponde a 0 y el concepto es enganche, creamos la comision por enganche
                    if ($request->concepto[0] == 'Enganche') {
                        $this->comisiones->generar_comision_enganche($contrato->id, $contrato->pagos_contrato[0]->id);
                    }

                    $delete_segmento = $request->segmento[$seg];
                } else {
                    $delete_segmento = $request->segmento[$seg - 1];
                }
                Pago::where('contrato_id', $contrato->id)->whereIn('estatus', ['Por Pagar'])->where('segmento', '>', $delete_segmento)->delete();
            } catch (\Exception $e) {
                $data['delete_segmentos'] = false;
            }

            if (!isset($contrato->pagos_contrato) && count($contrato->pagos_contrato) != 0) {
                $precio = $contrato->precio_de_compra;
            } else {
                $precio = Pago::where('contrato_id', $request->contrato_id)->whereIn('estatus', ['Por Pagar'])->where('segmento', '!=', 0)->sum('cantidad');
            }
            $this->log->add_log_contract(Auth::user(), 'pagos_log', $request, $contrato, $precio);
            $this->log->pagos_log($request, $contrato, $precio);

            $num_seg         = Pago::where('contrato_id', $contrato->id)->where('segmento', '!=', 0)->where('cantidad', '!=', 0.00)->count();
            $contrato->pagos = ($num_seg != null) ? $num_seg : $seg;
            $contrato->save();

            $data['success']       = true;
            $data['num_segmentos'] = $seg;
            $data['folio']         = $contrato->id;
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function show(Pago $pago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pago         = Pago::findOrFail($id);
        $data['view'] = view('admin.pagos.edit', compact('pago'))->render();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $pago                 = Pago::findOrFail($id);
        $data['success']      = false;
        $pago->estatus        = $request->estatus_pago;
        $pago->cantidad       = $request->cantidad;
        $pago->fecha_de_cobro = $request->fecha_de_cobro;

        $pago->concepto = $request->concepto;

        $estatus = array('Rechazado', 'Pagado');
        if (in_array($request->estatus_pago, $estatus)) {
            $pago->fecha_de_pago = $request->fecha_de_pago;
        }

        $pago->cobrador = Auth::user()->id;
        $pago->modified = Carbon::now();

        if ($pago->save()) {
            $data['success'] = true;
            $data['pago']    = $pago;
            $this->log->add_segmento_log($pago, Auth::user());
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pago  $pago
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = false;
        $pago            = Pago::findOrFail($id);
        if ($pago->delete()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    public function calcular_pagos(Request $request)
    {

        // dd($request->all());
        $data_pago = $this->obtener_info_pagos($request->contrato_id);
        // dd($data_pago, $request->all());
        // try {
        $contrato = Contrato::findOrFail($request->contrato_id);
        $temporal = $contrato->toArray();

        $contrato->tipo_pago = $request->metodo_pago;

        if (isset($request->descuento)) {
            if ($contrato->aplica_descuento != 1) {
                $descuento                  = $request->descuento;
                $sub                        = (($contrato->precio_de_compra / 100) * $descuento);
                $cantidad                   = ($contrato->precio_de_compra - $sub);
                $contrato->precio_de_compra = $cantidad;
                $contrato->aplica_descuento = 1;

                $log = "\n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
                $log .= "## **precio_de_compra**: \n";
                $log .= "+ ** " . $temporal['precio_de_compra'] . "**\n";
                $log .= "+ ** $cantidad **\n";

                $log .= "## **aplica_descuento**: \n";
                $log .= "+ ** **\n";
                $log .= "+ ** Aplica descuento del $descuento% **\n\n\n";
                $log .= "\n\n * * * \n\n";
                $contrato->log = $log . $contrato->log;
            }
        } else {
            $contrato->precio_de_compra = $contrato->estancia->precio;
            $contrato->aplica_descuento = 0;

            $log = "\n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
            $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
            $log .= "## **precio_de_compra**: \n";
            $log .= "+ ** " . $contrato->precio_de_compra . "**\n";
            $log .= "+ ** " . $contrato->estancia->precio . "**\n";

            $log .= "## **aplica_descuento**: \n";
            $log .= "+ ** **\n";
            $log .= "+ ** No aplica descuento **\n";
            $log .= "\n\n * * * \n\n";

            $contrato->log = $log . $contrato->log;
        }
        $contrato->save();

        $pagos = $this->pagos->calcular_pagos($request->contrato_id, $request->metodo_pago, $request->fecha_primer_descuento, $request->num_segmentos, $data_pago, $request->dia_x, $request->dia_y);

        return response()->json(['pagos' => $pagos]);

        // } catch (\Exception $e) {
        //     return response()->json(['errors' => $e->getMessage()]);
        // }
    }

    public function listar_pagos_contrato_old($contrato_id, $tipo = null)
    {

        $pagos = Pago::with('historial')->where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0]);
        $con   = Contrato::findOrFail($contrato_id);
        switch ($tipo) {
            case 'concretados':
                $pagos = $pagos->where('estatus', 'Pagado')->orderBy('segmento', 'ASC')->get();
                break;
            case 'rechazados':
                $pagos = $pagos->where('estatus', 'Rechazado')->orderBy('segmento', 'ASC')->get();
                break;
            case 'pendientes':
                $pagos = $pagos->where('estatus', 'Por Pagar')->orderBy('segmento', 'ASC')->get();
                break;
            default:
                $pagos = $pagos->orderBy('segmento', 'ASC')->get();
                break;
        }

        $fecha_primer_pago = $pagos->where('segmento', 1)->first();

        $pagados    = $pagos->where('estatus', 'Pagado')->count();
        $rechazados = $pagos->where('estatus', 'Rechazado')->count();
        $pendientes = $pagos->where('estatus', 'Por Pagar')->count();

        // dd($contrato_id, $tipo, $fecha_primer_pago, $pagados, $pagos);

        $segmentos_generados = $pagos->count();

        if ($pendientes == 0 && $rechazados != 0) {
            $segmentos_generados = $pagos->count() + $rechazados + $rechazados;
        }

        $data     = array();
        $i        = 1;
        $sfr      = '';
        $btnPagos = '';

        foreach ($pagos as $pago) {

            $btn = '';
            if (isset($pago->log)) {
                $btn .= '<button class="btn btn-dark btn-xs mr-1" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-tarjeta_id="" data-contrato_id="' . $pago->contrato->id . '" id="btnLogPago" type="button"><i class="fas fa-info-circle"></i></button>';
            }

            // $btn .= '<button class="btn btn- btn-xs mr-1" value="' . $pago->id . '" id="btnLog" type="button"><i class="fas fa-info-circle"></i></button>';

            if (Auth::user()->can('update', $pago)) {
                $btn .= '<button class="btn btn-info btn-xs mr-1" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-tarjeta_id="" data-contrato_id="' . $pago->contrato->id . '" id="btnEditarPago" type="button"><i class="fas fa-edit"></i></button>';
            }
            if (Auth::user()->can('delete', $pago)) {
                $btn .= '<button class="btn btn-danger btn-xs" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-estatus="' . $pago->estatus . '" data-tarjeta_id="" data-contrato_id="' . $pago->contrato->id . '" id="btnDeletePago" data-segmento="' . $pago->segmento . '" type="button" data-url="' . route('pagos.destroy', $pago->id) . '"><i class="fas fa-trash"></i></button>';
            }

            $sfr .= '<ul class="list-unstyled" style="font-size:10px;">';
            if ($pago->concepto == 'Enganche') {
                $sfr .= '<li>' . $pago->concepto . '</li>';
            }
            if ($pago->created_by) {
                $sfr .= '<li> Creado por: ' . $pago->created_by . '</li>';
            }
            foreach ($pago->historial_limit as $key => $historial) {
                $sfr .= '<li>' . $historial->motivo_del_rechazo . '</li>';
            }
            $sfr .= '</ul>';

            switch ($pago->estatus) {
                case 'Por Pagar':
                    $status = '<span class="label label-info">' . __('messages.user.show.pendientes') . '</span>';
                    break;
                case 'Rechazado':
                    $status = '<span class="label label-danger">' . __('messages.user.show.rechazados') . '</span>';
                    break;
                case 'Pagado':
                    $status = '<span class="label label-success">' . __('messages.user.show.concretados') . '</span>';
                    break;
                default:
                    $status = '<span class="label label-inverse">' . $pago->estatus . '</span>';
                    break;
            }

            $data[] = array(
                "1" => $pago->segmento,
                "2" => $status . '<br/>' . $sfr,
                "3" => number_format($pago->cantidad, 2),
                "4" => $pago->fecha_de_cobro,
                "5" => $pago->fecha_de_pago,
                "6" => $pago->estatus,
                "7" => $btn,
                "8" => $pago->id,
            );
            $btn = '';
            $sfr = '';
        }
        $fecha_inicial = ($fecha_primer_pago != null) ? $fecha_primer_pago->fecha_de_cobro : null;
        //DEVUELVE LOS DATOS EN UN JSON
        $results = array(
            "sEcho"               => 1,
            "iTotalRecords"       => count($data),
            "aaData"              => $data,
            "pagados"             => $pagados,
            "rechazados"          => $rechazados,
            "pendientes"          => $pendientes,
            "fecha_inicial"       => $fecha_inicial,
            "segmentos_generados" => $segmentos_generados,
            'view'                => view('admin.elementos.forms.formAddCalculador', compact('contrato_id', 'con', 'fecha_inicial', 'data', 'segmentos_generados', 'pagados', 'pendientes', 'rechazados'))->render(),
        );

        return response()->json($results);
    }

    public function obtener_info_pagos($contrato_id)
    {
        $con = Contrato::findOrFail($contrato_id);
        //Precio del paquete
        $info_pagos['precio_paquete'] = $con->precio_de_compra;

        //informacion de pagos pagados, cantidad paga y numero de segmentos pagados
        $info_pagado                         = Pago::where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Pagado');
        $info_pagos['cantidad_pagada']       = $info_pagado->sum('cantidad');
        $info_pagos['num_segmentos_pagados'] = $info_pagado->count();

        //Informacion de pagos pendientes, cantidad y numero de segmentos
        $info_pendiente = Pago::where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->whereNotIn('estatus', ['Pagado']);
        // $info_pagos['cantidad_pendiente'] = $info_pendiente->sum('cantidad');

        // Cantidad pendiente por pagar
        $info_pagos['cantidad_pendiente'] = $info_pagos['precio_paquete'] - $info_pagos['cantidad_pagada'];
        // numero de segmentos pendientes
        $info_pagos['num_segmentos_pendientes'] = $info_pendiente->count();

        //Total de pagos pendientes
        $info_pendiente_                = Pago::where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Por Pagar');
        $info_pagos['total_pendientes'] = $info_pendiente_->count();

        //Total de pagos pendientes
        $info_rechazados                        = Pago::where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Rechazado');
        $info_pagos['cantidad_rechazada']       = $info_rechazados->sum('cantidad');
        $info_pagos['num_segmentos_rechazados'] = $info_rechazados->count();

        //Total de pagos del contrato sin contar segmentos cero
        $info_pagos['total_segmentos'] = Pago::where('contrato_id', $contrato_id)->where('segmento', '!=', 0)->count();

        // Primer pago que esta con esatus por pagar para iniciar desde ese punto el recalculo sin tomar los pagos ya realizados exitosamente
        $inicio_pago = Pago::where('contrato_id', $contrato_id)->where('estatus', 'Por Pagar')->where('segmento', '!=', 0)->orderBy('id', 'ASC')->first();

        $info_pagos['fecha_inicial'] = ($inicio_pago) ? $inicio_pago->fecha_de_cobro : date('d-m-Y');
        // $info_pagos['segmento_inicial'] = ($inicio_pago) ? $inicio_pago->segmento : 1;

        // Primer pago que esta con esatus por pagar para iniciar desde ese punto el recalculo sin tomar los pagos ya realizados exitosamente
        $ultimo_pago                  = Pago::where('contrato_id', $contrato_id)->where('segmento', '!=', 0)->orderBy('id', 'DESC')->first();
        $info_pagos['fecha_final']    = ($ultimo_pago) ? $ultimo_pago->fecha_de_cobro : date('d-m-Y');
        $info_pagos['segmento_final'] = ($ultimo_pago) ? $ultimo_pago->segmento : 0;

        if ($inicio_pago == null) {
            $info_pagos['inicia_en_segmento'] = $info_pagos['segmento_final'] + 1;
        } else {
            $info_pagos['inicia_en_segmento'] = $inicio_pago->segmento;
        }

        return collect($info_pagos);
    }

    public function listar_pagos_contrato($contrato_id, $tipo = null)
    {
        $info_pagos = array();

        $pagos = Pago::with('historial')->where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0]);
        $con   = Contrato::findOrFail($contrato_id);
        switch ($tipo) {
            case 'concretados':
                $pagos = $pagos->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Pagado')->orderBy('segmento', 'ASC')->get();
                break;
            case 'rechazados':
                $pagos = $pagos->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Rechazado')->orderBy('segmento', 'ASC')->get();
                break;
            case 'pendientes':
                $pagos = $pagos->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Por Pagar')->orderBy('segmento', 'ASC')->get();
                break;
            default:
                $pagos = $pagos->orderBy('segmento', 'ASC')->get();
                break;
        }
        //Precio del paquete
        $info_pagos['precio_paquete'] = $con->precio_de_compra;

        //informacion de pagos pagados, cantidad paga y numero de segmentos pagados
        $info_pagado                         = Pago::where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Pagado');
        $info_pagos['cantidad_pagada']       = $info_pagado->sum('cantidad');
        $info_pagos['num_segmentos_pagados'] = $info_pagado->count();

        //Informacion de pagos pendientes, cantidad y numero de segmentos
        $info_pendiente = Pago::where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->whereNotIn('estatus', ['Pagado']);
        // $info_pagos['cantidad_pendiente'] = $info_pendiente->sum('cantidad');

        // Cantidad pendiente por pagar
        $info_pagos['cantidad_pendiente'] = $info_pagos['precio_paquete'] - $info_pagos['cantidad_pagada'];
        // numero de segmentos pendientes
        $info_pagos['num_segmentos_pendientes'] = $info_pendiente->count();

        //Total de pagos pendientes
        $info_pendiente_                = Pago::where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Por Pagar');
        $info_pagos['total_pendientes'] = $info_pendiente_->count();

        //Total de pagos pendientes
        $info_rechazados                        = Pago::where('contrato_id', $contrato_id)->whereNotIn('cantidad', [0])->where('segmento', '!=', 0)->where('estatus', 'Rechazado');
        $info_pagos['cantidad_rechazada']       = $info_rechazados->sum('cantidad');
        $info_pagos['num_segmentos_rechazados'] = $info_rechazados->count();

        //Total de pagos del contrato sin contar segmentos cero
        $info_pagos['total_segmentos'] = Pago::where('contrato_id', $contrato_id)->where('segmento', '!=', 0)->count();

        // Primer pago que esta con esatus por pagar para iniciar desde ese punto el recalculo sin tomar los pagos ya realizados exitosamente
        $inicio_pago = Pago::where('contrato_id', $contrato_id)->where('estatus', 'Por Pagar')->where('segmento', '!=', 0)->orderBy('id', 'ASC')->first();

        $info_pagos['fecha_inicial'] = ($inicio_pago) ? $inicio_pago->fecha_de_cobro : date('Y-m-d');
        // $info_pagos['segmento_inicial'] = ($inicio_pago) ? $inicio_pago->segmento : 1;

        // Primer pago que esta con esatus por pagar para iniciar desde ese punto el recalculo sin tomar los pagos ya realizados exitosamente
        $ultimo_pago                  = Pago::where('contrato_id', $contrato_id)->where('segmento', '!=', 0)->orderBy('id', 'DESC')->first();
        $info_pagos['fecha_final']    = ($ultimo_pago) ? $ultimo_pago->fecha_de_cobro : date('Y-m-d');
        $info_pagos['segmento_final'] = ($ultimo_pago) ? $ultimo_pago->segmento : 0;

        if ($inicio_pago == null) {
            $info_pagos['inicia_en_segmento'] = $info_pagos['segmento_final'] + 1;
        } else {
            $info_pagos['inicia_en_segmento'] = $inicio_pago->segmento + 1;
        }

        $data_pagos = collect($info_pagos);
        // dd($data_pagos);

        $data     = array();
        $i        = 1;
        $sfr      = '';
        $btnPagos = '';

        foreach ($pagos as $pago) {
            $btn = '';
            if (isset($pago->log)) {
                $btn .= '<button class="btn btn-dark btn-xs mr-1" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-tarjeta_id="" data-contrato_id="' . $pago->contrato->id . '" id="btnLogPago" type="button"><i class="fas fa-info-circle"></i></button>';
            }
            if (Auth::user()->can('update', $pago)) {
                $btn .= '<button class="btn btn-info btn-xs mr-1" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-tarjeta_id="" data-contrato_id="' . $pago->contrato->id . '" id="btnEditarPago" type="button"><i class="fas fa-edit"></i></button>';
            }
            if (Auth::user()->can('delete', $pago)) {
                $btn .= '<button class="btn btn-danger btn-xs" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-estatus="' . $pago->estatus . '" data-tarjeta_id="" data-contrato_id="' . $pago->contrato->id . '" id="btnDeletePago" data-segmento="' . $pago->segmento . '" type="button" data-url="' . route('pagos.destroy', $pago->id) . '"><i class="fas fa-trash"></i></button>';
            }

            $sfr .= '<ul class="list-unstyled" style="font-size:10px;">';
            if ($pago->concepto == 'Enganche') {
                $sfr .= '<li>' . $pago->concepto . '</li>';
            }
            if ($pago->created_by) {
                $sfr .= '<li> Creado por: ' . $pago->created_by . '</li>';
            }
            foreach ($pago->historial_limit as $key => $historial) {
                $sfr .= '<li>' . $historial->motivo_del_rechazo . '</li>';
            }
            $sfr .= '</ul>';

            switch ($pago->estatus) {
                case 'Por Pagar':
                    $status = '<span class="label label-info">' . __('messages.user.show.pendientes') . '</span>';
                    break;
                case 'Rechazado':
                    $status = '<span class="label label-danger">' . __('messages.user.show.rechazados') . '</span>';
                    break;
                case 'Pagado':
                    $status = '<span class="label label-success">' . __('messages.user.show.concretados') . '</span>';
                    break;
                default:
                    $status = '<span class="label label-inverse">' . $pago->estatus . '</span>';
                    break;
            }

            $data[] = array(
                "1" => $pago->segmento,
                "2" => $status . '<br/>' . $sfr,
                "3" => number_format($pago->cantidad, 2),
                "4" => $pago->fecha_de_cobro,
                "5" => $pago->fecha_de_pago,
                "6" => $pago->estatus,
                "7" => $btn,
                "8" => $pago->id,
                "9" => (Auth::user()->can('delete', $pago)) ? '<div class="demo-checkbox"><input type="checkbox" id="pago_id_' . $pago->id . '" name="pagoDelete[]" value="' . $pago->id . '" class="filled-in chk-col-blue"><label for="pago_id_' . $pago->id . '"></label></div>' : '',
            );
            $btn = '';
            $sfr = '';
        }
        //DEVUELVE LOS DATOS EN UN JSON
        $results = array(
            "sEcho"         => 1,
            "iTotalRecords" => count($data),
            "aaData"        => $data,
            "info_pagos"    => $info_pagos,
            'view'          => view('admin.elementos.forms.formAddCalculador', compact('con', 'data', 'data_pagos'))->with(['info_pagos' => $info_pagos])->render(),
        );
        // dd($results);
        return response()->json($results);
    }

    public function add_pago(Request $request)
    {
        $pago = Pago::create([
            'contrato_id'    => $request->contrato_id,
            'segmento'       => 0,
            'estatus'        => "Por Pagar",
            'fecha_de_cobro' => Carbon::parse($request->fecha_de_cobro)->format('Y-m-d'),
            'cantidad'       => $request->cantidad,
            'created_by'     => Auth::user()->fullName,
            'concepto'       => $request->concepto,
        ]);

        $data['success'] = false;

        if ($pago) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    public function get_log($pago_id)
    {
        $pago = Pago::findOrFail($pago_id);

        $data['success']  = true;
        $data['log_pago'] = $pago->logPago;

        return response()->json($data);
    }

    public function delete_multiple(Request $request)
    {

        $res['success'] = false;

        try {
            $segmentos = $request->pagoDelete;
            $i         = 0;
            foreach ($segmentos as $seg) {
                $i++;
                $delete = Pago::destroy($seg);
            }

            if ($i > 0) {
                $res['success']    = true;
                $res['eliminados'] = $i;
            }
        } catch (\Exception $e) {
            $res['errors'] = $e->getMessage();
        }
        return response()->json($res);
    }

    public function delete_restantes($contrato_id)
    {
        $data['success']        = false;
        $num_segmento_restantes = Pago::where('contrato_id', $contrato_id)->where('estatus', 'Por Pagar')->count();
        try {
            if ($num_segmento_restantes != 0) {
                $segmento_restantes = Pago::where('contrato_id', $contrato_id)->where('estatus', 'Por Pagar')->delete();
                if ($segmento_restantes != 0) {
                    $data['success'] = true;
                    $data['message'] = 'Se eliminaron ' . $num_segmento_restantes . ' segmentos pendientes';
                }
            } else {
                $data['success'] = true;
                $data['message'] = 'No se cuentan con segmentos pendientes.';
            }
        } catch (\Exception $e) {
            $data['exceptions'] = $e->getMessage();
        }

        return response()->json($data);
    }
}
