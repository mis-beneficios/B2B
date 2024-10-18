<?php
namespace App\Http\Controllers;

use App\Comision;
use App\Contrato;
use App\ContratosReservaciones as CR;
use App\Convenio;
use App\Estancia;
use App\Helpers\ComisionesHelper;
use App\Helpers\ContratoPDFHelper;
use App\Helpers\LogHelper;
use App\Helpers\SmsHelper;
use App\Imagen;
use App\JobNotifications;
use App\Jobs\ExportBases;
use App\Mail\Mx\EnviarContrato;
use App\Mail\ReenvioContratoMx;
use App\Mail\ReenvioContratoUsa;
use App\Padre;
use App\Pago;
use App\Tarjeta;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Log;
use Mail;
use Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Utils;

class ContratoController extends Controller
{
    private $contrato_pdf;

    public function __construct()
    {
        $this->middleware('auth');
        $this->contrato_pdf = new ContratoPDFHelper;

        $this->log        = new LogHelper;
        $this->comisiones = new ComisionesHelper;
        $this->sms        = new SmsHelper;
    }

    /**
     * Validacion de formulario para crear contrato
     * Autor: Diego Enrique Sanchez
     * Creado: 2022-10-28
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_form(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'tarjeta_id' => ($request->venta_contado || $request->pago_nomina) ? '' : 'required',
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
        return view('admin.contratos.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listar_contratos_ejecutivo($user_id)
    {
        return view('admin.contratos.listar_contratos_ejecutivo', compact('user_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id   = $request->user_id;
        $p_info = json_encode(['opcion'=>'get_tarjetas','id_pais'=>env('APP_PAIS_ID'),'id_cliente'=>$user_id]);
        $tarjetas = (new Utils)->get_config($p_info)['data'];
        $p_info = json_encode(['opcion'=>'get_estancias','id_pais'=>env('APP_PAIS_ID')]);
        $estancias = (new Utils)->get_config($p_info)['data'];


        $data['view'] = view('admin.elementos.forms.formAddContrato', compact('tarjetas', 'estancias', 'user_id'))->render();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validate = $this->validar_form($request);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        if (!isset($request->venta_contado)) {
            $tarjeta = Tarjeta::find($request->tarjeta_id);
        }

        $est             = Estancia::findOrFail($request->estancia_id);
        $cli             = User::findOrFail($request->user_id, ['id', 'username', 'convenio_id', 'nombre', 'apellidos']);
        $data['success'] = false;
        $fecha           = Carbon::now();
        $padre_id        = Padre::where('user_id', Auth::user()->id)->first()->id;

        $contrato              = new Contrato;
        $contrato->user_id     = $cli->id;
        $contrato->convenio_id = $cli->convenio_id;
        $contrato->estancia_id = $est->id;

        if (isset($request->venta_contado)) {
            $contrato->tarjeta_id      = null;
            $contrato->pago_con_nomina = 0;
            $contrato->via_serfin      = 0;
        } else if (isset($request->pago_nomina)) {
            $contrato->tarjeta_id      = null;
            $contrato->pago_con_nomina = 1;
            $contrato->via_serfin      = 0;
        } else {
            $contrato->tarjeta_id      = $request->tarjeta_id;
            $contrato->pago_con_nomina = $tarjeta->r_banco->ignorar_en_via_serfin == 1 ? 0 : (($request->pago_nomina) ? 1 : 0);
            $contrato->via_serfin      = $tarjeta->r_banco->ignorar_en_via_serfin == 1 ? 0 : (($request->pago_nomina) ? 0 : 1);
        }
        $contrato->paquete                         = $est->title;
        $contrato->estatus                         = 'por_autorizar';
        $contrato->precio_de_compra                = ($request->num_pax) ? (($est->cuotas * $est->precio_por_adulto) * $request->num_pax) : $est->precio;
        $contrato->pago_con_otras_tarjetas         = 0;
        $contrato->estatus_de_pagos                = 0;
        $contrato->padre_id                        = $padre_id;
        $contrato->noches                          = $est->noches;
        $contrato->adultos                         = ($request->num_pax) ? $request->num_pax : $est->adultos;
        $contrato->ninos                           = $est->ninos;
        $contrato->divisa                          = $est->divisa;
        $contrato->created                         = $fecha;
        $contrato->modified                        = $fecha;
        $contrato->edad_max_ninos                  = $est->edad_max_ninos;
        $contrato->layout_processed                = ($contrato->via_serfin == 1) ? 1 : 0;
        $contrato->estatus_comisiones              = 'sin_procesar';
        $contrato->comisiones_actualizadas         = 0;
        $contrato->reservacion_en_proceso          = 0;
        $contrato->importado                       = 0;
        $contrato->tipo_llamada                    = $request->tipo_llamada;
        $contrato->usd_mxp                         = 0;
        $contrato->autorizo                        = 0;
        $contrato->agreeterms                      = 0;
        $contrato->numero_de_empleado              = 0;
        $contrato->alerta_user_enviada             = 0;
        $contrato->alerta_compra                   = 0;
        $contrato->alerta_compra_fecha             = $fecha;
        $contrato->alerta_compra_enviada_a         = '';
        $contrato->fecha_primer_segmento           = $fecha;
        $contrato->fecha_primer_descuento_contrato = $fecha;
        $contrato->pagos                           = 0;
        $contrato->cantidad_pagos_hechos           = 0;
        // dd($contrato);
        if ($contrato->save()) {
            $this->comisiones->generar_comisiones($contrato->id, $contrato->convenio_id);
            $contrato_id     = $contrato->id;
            $con             = $contrato;
            $data            = false;
            $data_pagos      = $this->obtener_info_pagos($contrato->id);
            $data['success'] = true;
            $data['view']    = view('admin.elementos.forms.formAddCalculador', compact('contrato_id', 'con', 'data', 'data_pagos'))->render();
        }

        return response()->json($data);
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

        return collect($info_pagos);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function show(Contrato $contrato)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contrato = Contrato::findOrFail($id);
        $tarjetas = Tarjeta::where('user_id', $contrato->user_id)->get();

        $data['view']    = view('admin.elementos.forms.formEditarContrato', compact('contrato', 'tarjetas'))->render();
        $data['success'] = true;
        $data['titulo']  = __('messages.editar_contrato');

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data['success'] = false;
        $contrato        = Contrato::findOrFail($id);

        //define los cambios que se realizaron en el registro
        $temporal = $contrato->toArray();
        // $temporal = array(
        //     'tarjeta_id'       => $contrato->tarjeta_id,
        //     'paquete'          => $contrato->paquete,
        //     'sys_key'          => $contrato->sys_key,
        //     'precio_de_compra' => $contrato->precio_de_compra,
        //     'adultos'          => $contrato->adultos,
        //     'ninos'            => $contrato->ninos,
        //     'edad_max_ninos'   => $contrato->edad_max_ninos,
        //     'pago_con_nomina'  => $contrato->pago_con_nomina,
        //     'estatus'          => $contrato->estatus,
        //     'motivo_estatus'   => $contrato->motivo_cancelacion,
        //     'divisa'           => $contrato->divisa,
        //     'tipo_llamada'     => $contrato->tipo_llamada,
        // );

        $contrato->tarjeta_id       = $request->tarjeta_id;
        $contrato->paquete          = $request->paquete;
        $contrato->sys_key          = $request->sys_key;
        $contrato->precio_de_compra = $request->precio_de_compra;
        $contrato->adultos          = $request->adultos;
        $contrato->ninos            = $request->ninos;
        $contrato->edad_max_ninos   = $request->edad_max_ninos;
        $contrato->motivo_estatus   = $request->motivo_cancelacion;

        if ($request->pago_nomina) {
            $contrato->pago_con_nomina = 1;
        } else {
            $contrato->pago_con_nomina = 0;
        }

        $contrato->estatus      = $request->estatus;
        $contrato->divisa       = $request->divisa;
        $contrato->tipo_llamada = $request->tipo_llamada;

        if ($contrato->save()) {
            if (array_diff($contrato->getChanges(), $temporal)) {
                $log = $this->log->contrato_log_editar(Auth::user(), $contrato->getChanges(), $temporal, $contrato);

                if ($request->estatus == 'cancelado') {
                    $log_motivo = $this->log->contrato_log_cambio_estatus(Auth::user(), $contrato->getChanges(), $contrato->motivo_estatus, $contrato);
                }
            }
            $data['success']     = true;
            $data['contrato_id'] = $contrato->id;
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Contrato  $contrato
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = false;
        try {
            $contrato = Contrato::findOrFail($id);
            Pago::where('contrato_id', $contrato->id)->delete();

            if ($contrato->delete()) {
                $data['success'] = true;
            }
        } catch (\Exception $e) {
            $data['errors'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-10
     * Mostratos el historial de acciones que se han realizado a un contrato
     * @param  [int] $id
     * @return [json]
     */
    public function historial($id)
    {
        $contrato        = Contrato::findOrFail($id);
        $data['success'] = false;
        if ($contrato) {
            $data['success']   = true;
            $data['historico'] = $contrato->logContrato;
        }

        return response()->json($data);
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-10
     * Listado de contratos generados por el usuario logueado
     * @return [array]
     */
    public function listar_contratos($user_id = null)
    {
        /*if (isset($user_id)) {
            $padre_id = Padre::where('user_id', $user_id)->first()->id;
        } else {
            $padre_id = Padre::where('user_id', Auth::user()->id)->first()->id;
        }

        $contratos = Contrato::with('cliente')->where('padre_id', $padre_id)->get();
        */
        $contratos = (new Contrato)->sp_contratos_porUsuario(Auth::user()->id);

        $data     = array();
        $i        = 1;
        $btn      = '';
        $btnPagos = '';

        foreach ($contratos['data'] as $contrato) {
            // $btn .= '<a href="' . route('users.show', $user->id) . '" class="btn btn-dark btn-xs"><i class="fas fa-eye"></i></a>';

            $data[] = array(
                "0" => $contrato['id'],
                "1" => '<a href="' . route('users.show', $contrato['id_cliente']) . '">' . $contrato['nombre_cliente'] . '</a>',
                "2" => $contrato['username'],
                "3" => $contrato['empresa_nombre'],
                "4" => $contrato['title'],
                "5" => Carbon::create($contrato['created'])->diffForHumans(),
                // "4" => $btn,
            );
            $btn = '';
        }
        //DEVUELVE LOS DATOS EN UN JSON
        $results = array(
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"               => $data,
        );
        return response()->json($results);
    }

    public function reenviar_contrato($id)
    {

        $contrato = Contrato::findOrFail($id);

        try {
            if ($contrato->estancia->estancia_paise_id == 7) {
                $name = $this->contrato_pdf->obtener_contrato_pdf($id);
                Mail::to($contrato->cliente->username)->send(new ReenvioContratoUsa($contrato));
                $data['success'] = true;
            } else if ($contrato->estancia->estancia_paise_id == 1 || $contrato->estancia->estancia_paise_id == 0) {
                $name = $this->contrato_pdf->obtener_contrato_pdf_mx($id);
                Mail::to($contrato->cliente->username)->send(new ReenvioContratoMx($contrato));
                $data['success'] = true;
            } else {
                $data['success'] = false;
            }
        } catch (\Exception $e) {
            $this->sms->send_sms($e->getMessage());
            Log::critical($e->getMessage());
            $data['success'] = false;
        }

        return response()->json($data);
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-04
     * Ontenemos el formato en texto plano para pintar el contrato en html
     * @param  [int] $id
     * @return [json]
     */
    public function mostrar_contrato($id)
    {
        // dd($id);
        $contrato = Contrato::findOrFail($id);

        if ($contrato->estancia->estancia_paise_id == 7) {
            $res             = $this->contrato_pdf->mostrar_contrato($id);
            $data['formato'] = $res['formato'];
            $data['name']    = $res['name'];
            $data['pais_id'] = 'eu';
            $data['success'] = true;

        } else if ($contrato->estancia->estancia_paise_id == 1 || $contrato->estancia->estancia_paise_id == 0) {
            $res             = $this->contrato_pdf->mostrar_contrato_mx($id);
            $data['formato'] = $res['formato'];
            $data['name']    = $res['name'];
            $data['pais_id'] = 'mx';
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }
        return response()->json($data);
    }

    public function descargar_contrato($id)
    {

        $contrato = Contrato::findOrFail($id);
        if ($contrato->estancia->estancia_paise_id == 7) {
            $name            = $this->contrato_pdf->obtener_contrato_pdf($id);
            $data['success'] = true;
        } else if ($contrato->estancia->estancia_paise_id == 1 || $contrato->estancia->estancia_paise_id == 0) {
            $name            = $this->contrato_pdf->obtener_contrato_pdf_mx($id);
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        return $name;
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-15
     * Modificamos la estancia y recalculamos los pagos pendientes, restando la cantidad ya pagada
     * @param  Request $request
     * @return [response]
     */
    public function cambio_estancia(Request $request)
    {
        $data['success'] = false;
        $contrato        = Contrato::findOrFail($request->contrato_id);
        $estancia        = Estancia::findOrFail($request->estancia_id);

        $this->log->pagos_log_cambio_estancia($contrato);
        $this->log->contrato_log_cambio_estancia(Auth::user(), $contrato, $estancia);

        $contrato->estancia_id      = $estancia->id;
        $contrato->precio_de_compra = $estancia->precio;
        $contrato->paquete          = $estancia->title;
        $contrato->estancia_id      = $estancia->id;
        $contrato->divisa           = $estancia->divisa;

        // Calcular pagos a actualizar
        $pagos_concretados = $contrato->pagos_contrato->where('estatus', 'Pagado')->sum('cantidad');
        $pagos_restantes   = $contrato->pagos_contrato->where('estatus', 'Por Pagar')->count();
        if ($pagos_restantes != 0) {
            $precio_final = ($estancia->precio - $pagos_concretados) / $pagos_restantes;
            Pago::where('contrato_id', $contrato->id)
                ->where('estatus', 'Por Pagar')
                ->update(['cantidad' => $precio_final]);
        }

        if ($contrato->save()) {

            $data['success'] = true;
        }

        return response()->json($data);
    }

    public function metodo_de_pago_show($id)
    {
        $contrato = Contrato::findOrFail($id);

        $data['success'] = true;
        $data['titulo']  = 'Metodo de pago';
        $data['view']    = view('admin.elementos.forms.formMetodoPagoContrato', compact('contrato'))->render();
        return response()->json($data);
    }

    public function metodo_pago(Request $request, $id)
    {
        $data['success'] = false;
        $contrato        = Contrato::findOrFail($id);

        $temporal = array(
            'pago_con_nomina' => $contrato->pago_con_nomina,
            'via_serfin'      => $contrato->via_serfin,
        );

        switch ($request->metodo_de_pago) {
            case 'nomina':
                $contrato->pago_con_nomina = 1;
                $contrato->via_serfin      = 0;
                break;
            case 'terminal':
                $contrato->pago_con_nomina = 0;
                $contrato->via_serfin      = 0;
                break;
            case 'serfin':
                $contrato->pago_con_nomina = 0;
                $contrato->via_serfin      = 1;
                break;
        }

        if ($contrato->save()) {
            if (array_diff($contrato->getChanges(), $temporal)) {
                $log = $this->log->contrato_log_editar(Auth::user(), $contrato->getChanges(), $temporal, $contrato);
            }
            $data['success'] = true;

            return response()->json($data);
        }
    }

    public function autorizar_folio(Request $request)
    {
        $data['success'] = false;
        $contrato        = Contrato::findOrFail($request->contrato_id);

        $temporal = array(
            'estatus' => $contrato->estatus,
        );

        $contrato->estatus = 'comprado';

        if ($contrato->save()) {

            if (array_diff($contrato->getChanges(), $temporal)) {
                $log = $this->log->contrato_log_editar(Auth::user(), $contrato->getChanges(), $temporal, $contrato);
            }

            try {
                $contrato_pdf = $this->contrato_pdf->obtener_contrato_pdf_mx($contrato->id);
                Mail::mailer('smtp')->to($contrato->cliente->username)->send(new EnviarContrato($contrato));
                // Mail::to('dsanchez@pacifictravels.mx')->send(new EnviarContrato($contrato));
            } catch (Exception $e) {
                $this->sms->send_sms($e->getMessage());
                Log::critical($e->getMessage());
                Log::error('No se pudo enviar el pdf del contrato: ' . $contrato->id);
            }
            $data['success'] = true;
        }
        return response()->json($data);
    }

    public function contratos_por_autorizar()
    {
        return view('admin.contratos.por_autorizar');
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-10
     * Listado de contratos generados por el usuario logueado
     * @return [array]
     */
    public function obtener_contratos($estatus = null, $equipo = null)
    {

        $contratos = DB::table('contratos as c')
            ->join('users as u', 'c.user_id', 'u.id')
            ->join('convenios as con', 'c.convenio_id', 'con.id')
            ->join('padres as p', 'c.padre_id', 'p.id')
            ->join('users as up', 'p.user_id', 'up.id')
            ->select('c.id as contrato_id', 'u.id', DB::raw('concat(u.nombre , " ", u.apellidos) as cliente'), 'con.empresa_nombre', 'p.title as vendedor', 'c.created', DB::raw('count(c.id) as cantidad'))
            ->whereIn('c.estatus', [$estatus])
        // ->groupBy('c.created', 'cliente', 'u.id', 'contrato_id', 'con.empresa_nombre', 'vendedor')
        // ->groupBy('c.created', 'cliente')
            ->groupBy('u.id')
            ->orderBy('c.created', 'DESC')
            ->get();

        // dd($contratos);
        $data     = array();
        $i        = 1;
        $btn      = '';
        $btnPagos = '';

        foreach ($contratos as $contrato) {
            $data[] = array(
                "1" => $contrato->contrato_id,
                "2" => $contrato->cliente,
                "3" => $contrato->empresa_nombre,
                "4" => $contrato->vendedor,
                "5" => Carbon::createFromDate($contrato->created)->diffForHumans(),
                "6" => $contrato->cantidad,
                "7" => '<a href="' . route('users.show', $contrato->id) . '" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>',
            );
            $btn = '';

        }
        //DEVUELVE LOS DATOS EN UN JSON
        $results = array(
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"               => $data,
        );
        return response()->json($results);
    }

    public function generar_comisiones()
    {
        $contratos = Contrato::whereHas('convenio', function ($q) {
            $q->where('paise_id', 1);
        })->where('created', '>=', '2021-11-20 12:32:40')->get();

        foreach ($contratos as $contrato) {
            $this->comisiones->generar_comisiones($contrato->id, $contrato->convenio_id);
        }
    }

    public function contratos_por_convenio($convenio_id)
    {
        $contratos = Contrato::where('convenio_id', $convenio_id);
        // ->get()->dd();
        // dd($contratos->get());
        return DataTables::eloquent($contratos)

            ->editColumn('id', function ($contratos) {
                return '<a class="btn btn-dark btn-xs" href="' . route('users.show', $contratos->user_id) . '" role="button">' . $contratos->id . '</a>';
            })

            ->addColumn('cliente', function ($contratos) {
                return '<a class="" href="' . route('users.show', $contratos->user_id) . '" role="button">' . $contratos->cliente->fullName . '</a>';
            })

            ->addColumn('estancia', function ($contratos) {
                return (isset($contratos->estancia)) ? $contratos->estancia->title : 'Sin registro';
            })

            ->addColumn('creado', function ($contratos) {
                return $contratos->diffForhumans();
            })
            ->editColumn('estatus', function ($contratos) {
                return '<span class="label" style="background: ' . $contratos->color_estatus() . '">' . $contratos->estatus . '</span>';
            })
            ->rawColumns(['id', 'cliente', 'estancia', 'creado', 'estatus'])
            ->make(true);
    }

    public function cambiar_padre($contrato_id)
    {
        $contrato     = contrato::findOrFail($contrato_id);
        $padres       = Padre::with('vendedor')->get();
        $data['view'] = view('admin.users.elementos.cambiar_vendedor', compact('contrato', 'padres'))->render();
        return response()->json($data);

    }

    public function cambiar_vendedor(Request $request, $contrato_id)
    {
        $data['success'] = false;
        $contrato        = Contrato::findOrFail($contrato_id);
        $padre           = Padre::findOrFail($request->user_id);

        $comision = Comision::where(['contrato_id' => $contrato_id, 'user_id' => $contrato->padre->user_id])->first();
        if ($comision) {
            $comision->user_id = $padre->user_id;
            $comision->save();
        }
        $contrato->padre_id = $padre->id;

        if ($contrato->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    public function reservaciones_vinculadas($id)
    {
        $data['success'] = false;
        $data['message'] = 'No existe ningún vinculo a este folio.';
        $val             = '';
        $reservaciones   = CR::where('contrato_id', $id)->get();

        if (count($reservaciones) > 0) {
            $data['success']  = true;
            $data['message']  = 'Existen ' . count($reservaciones) . ' reservacion(es) vinculada(s) a este folio.';
            $data['question'] = '¿Desea desvincular de alguna reservacion?';
            foreach ($reservaciones as $res) {
                $val .= '<tr>
                          <td>#' . $res->id . '</td>
                          <td>' . $res->reservacione_id . '</td>
                          <td>' . $res->contrato_id . '</td>
                          <td><button class="btn btn-sm btn-danger"  data-contrato_id="' . $res->contrato_id . '"  data-reservacion_id="' . $res->reservacione_id . '" data-url="' . route('contratos.desvincular', [$res->id, $res->contrato_id]) . '" id="btnDesvincularContrato"><i class="fas fa-chain-broken"></i></button></td>
                        </tr>';
            }

            $data['table'] = '<div class="table-responsive">
                        <table class="table table-striped table-hover">
                          <thead class="thead-dark|thead-light">
                            <tr>
                              <th scope="col">CR</th>
                              <th scope="col">Reservacion</th>
                              <th scope="col">Contrato</th>
                              <th scope="col">Opciones</th>
                            </tr>
                          </thead>
                          <tbody>
                            ' . $val . '
                          </tbody>
                        </table>
                    </div>';

        }

        return response()->json($data);
    }

    public function desvincular($id, $contrato_id = null)
    {

        try {
            $reservacion = CR::findOrFail($id);
            // $contrato_id = $reservacion->contrato_id;
            if ($reservacion->delete()) {

                $con = Contrato::where('id', $contrato_id)->first();
                // ->update(['estatus' => 'comprado']);
                $con->estatus = 'comprado';

                $old_log = $con->log;

                $log = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";

                $log .= "### ** Desvinculación **: \n";
                $log .= "+ **  ** \n";
                $log .= "+ ** Se desvinculo el folio " . $contrato_id . " de la reservacion: " . $id . "** \n\n";

                $log .= "* * * \n\n";
                $con->log = $log . $old_log;
                $con->save();

                $data['success'] = true;

                $data['message'] = 'Se ha desvinculado el folio: ' . $contrato_id . ', ahora puede vincularlo a alguna otra reservacion.';
            } else {
                $data['success'] = false;
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }

        return response()->json($data);
    }

    public function add_calidad(Request $request)
    {
        $data['success'] = false;
        $contrato        = Contrato::findOrFail($request->contrato_id);
        // dd($request->all());
        $images = $request->file('images');
        foreach ($images as $imagen) {
            $name         = str_replace(' ', '-', $imagen->getClientOriginalName());
            $nombreImagen = 'files/calidad/' . $contrato->id . '/' . uniqid() . '_' . $name;

            $res = Storage::disk('s3')->put($nombreImagen, file_get_contents($imagen));

            if ($res) {
                $img             = new Imagen;
                $img->model      = 'Contrato';
                $img->model_id   = $contrato->id;
                $img->nombre     = $name;
                $img->path       = $nombreImagen;
                $img->driver     = 's3';
                $img->user_id    = Auth::id();
                $img->cliente_id = $contrato->user_id;
                $img->save();
                $data['success'] = true;
            }
        }

        return response()->json($data);
    }

    public function ver_calidad($contrato_id)
    {
        $images = Imagen::where('model_id', $contrato_id)->get();

        $data['view'] = view('admin.contratos.elementos.calidades', compact('images'))->render();

        return response()->json($data);
    }

    public function download_calidad($path)
    {
        $imagen = str_replace(',', '/', $path);
        return Storage::disk('s3')->download($imagen);
    }

    public function delete_calidad($path, $id)
    {

        $data['success'] = false;

        $imagen = str_replace(',', '/', $path);
        if (Storage::disk('s3')->delete($imagen)) {
            Imagen::destroy($id);
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /*
     * Mostramos las vistas para filtrar bases de ejecutivos
     */
    public function bases()
    {
        $ejecutivos        = User::whereIn('role', ['sales', 'supervisor'])->get();
        $estatus_contratos = Contrato::groupBy('estatus')->get('estatus');

        return view('admin.contratos.bases', compact('ejecutivos', 'estatus_contratos'));
    }

    // /**
    //  * Autor: Isw. Diego Sanchez
    //  * Creado: 2022-06-13
    //  * Llamamos la clade "ExportVentas" para generar el archivo excel con el filtrado de ventas solicitadas por el usuario
    //  * @param  Request $request
    //  * @return response json
    //  */
    // public function exportFiltrado(Request $request, $id = null)
    // {

    //     $data['success'] = false;

    //     $req['fecha_inicio'] = $request->fecha_inicio;
    //     $req['fecha_fin']    = $request->fecha_fin;
    //     $req['ejecutivos']   = $request->ejecutivos_select;
    //     $req['estatus']      = $request->estatus_contratos;

    //     $proceso = ExportBases::dispatch($req, $id)->onQueue('filter');

    //     if ($proceso != null) {
    //         $data['success'] = true;
    //         $data['message'] = 'El proceso se está ejecutando en segundo plano, te avisaremos cuando el archivo este listo.';
    //     }
    //     return response()->json($data);
    // }

    /**
     * Autor: ISW Diego Sanchez
     * Creado: 2024-02-21
     * Descripcion: lanzamos la crecion del archivo de base mediante colas
     */
    public function generarBase(Request $request)
    {

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin    = $request->fecha_fin;
        $estatus      = $request->estatus_contratos;
        $ejecutivos   = $request->ejecutivos_select;
        $archivo_name = 'Base-' . $fecha_inicio . '-al-' . $fecha_fin . '-' . Carbon::now()->format('hi') . '.xlsx';
        $telefon      = ($request->telefono) ? $request->telefono : null;

        $proceso = ExportBases::dispatch($fecha_inicio, $fecha_fin, $ejecutivos, $estatus, $archivo_name)->onQueue('filter');

        if ($proceso != null) {

            if ($request->telefono) {
                $notificacion           = new JobNotifications;
                $notificacion->numero   = $request->telefono;
                $notificacion->job_name = $archivo_name;
                $notificacion->estatus  = 0;
                $notificacion->file     = 'Archivo listo, descargar: ' . route('comisiones.download', $archivo_name);
                $notificacion->tipo     = 'base';
                $notificacion->user_id  = Auth::id();
                if ($notificacion->save()) {
                    $data['notificacion'] = $notificacion;
                }
            }

            $data['success'] = true;
            $data['message'] = 'El proceso se está ejecutando en segundo plano, te avisaremos cuando el archivo este listo.';
        }

        return response()->json($data);
    }

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2024-02-13
     * Llamamos la clade "ExportVentas" para generar el archivo excel con el filtrado de ventas solicitadas por el usuario
     * @param  Request $request
     * @return response json
     */
    // public function exportBase($request, $name = null)
    // {
    //     $data['success'] = false;

    //     $fecha_inicio = $request['fecha_inicio'];
    //     $fecha_fin    = $request['fecha_fin'];
    //     $estatus      = $request['estatus_contratos'];
    //     $ejecutivos   = $request['ejecutivos_select'];
    //     $archivo_name = isset($name) ? $name : '';

    //     dd($fecha_inicio, $fecha_fin, $ejecutivos, $estatus, $archivo_name);
    //     $proceso = ExportBases::dispatch($fecha_inicio, $fecha_fin, $ejecutivos, $estatus, $archivo_name)->onQueue('filter');

    //     if ($proceso != null) {
    //         $data['success'] = true;
    //         $data['message'] = 'El proceso se está ejecutando en segundo plano, te avisaremos cuando el archivo este listo.';
    //     }

    //     return response()->json($data);
    // }

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-13
     * Retornamos la descarga para procesarla por ajax y no recargar ni redireccionar al usuario
     * @param  string $name nombre del archivo a descargar
     * @return response download
     */
    public function downloadFiltrado($name)
    {
        // return response()->download(public_path() . "/files/filtrados/" . $name);
        return Storage::disk('filtrados')->download($name);
    }

}
