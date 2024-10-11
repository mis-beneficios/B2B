<?php

namespace App\Http\Controllers;

use App\Configuracion;
use App\Contrato;
use App\Convenio;
use App\Exports\ClientesExport;
use App\Exports\CobranzaDobleExport;
use App\Exports\FiltradoSerfin;
use App\Exports\SinSegmento;
use App\Exports\ClientesTerminalExport;
// use App\Exports\FiltradoBancomer;
use App\Exports\BBVAExport;
use App\Helpers\LogHelper;
// use App\Http\Controllers\TarjetaController;
use App\Pago;
use App\Pais;
use App\Serfinrespuestas;
use App\Tarjeta;
// use App\Tarjeta as Tar; 
use App\Traits\CobranzaHelper;
use App\Traits\TerminalTrait;
use App\User;
use Auth;
use Carbon\Carbon;
use DataTables;
use Excel;
use Illuminate\Http\Request;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use DB;

class CobranzaController extends Controller
{
    use CobranzaHelper, TerminalTrait;

    private $now;
    public function __construct()
    {
        $this->now  = Carbon::now();
        // $this->card = new TarjetaController;
        $this->log  = new LogHelper;
    }


    public function termial_ajax()
    {
        $this->authorize('view', Cobranza::class);
        $convenios = Convenio::select('id', 'empresa_nombre')->where('paise_id', 1)->get();
        $paises    = Pais::select('id', 'title')->get();
        return view('admin.cobranza.terminal_ajax', compact('convenios','paises'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // dd($request->all());
        $this->authorize('view', Cobranza::class);
        
        $convenios = Convenio::select('id', 'empresa_nombre')->where('paise_id', 1)->get();
        $paises    = Pais::select('id', 'title')->get();
        // return view('admin.cobranza.terminal_ajax', compact('convenios', 'paises'));
        // return view('admin.cobranza.terminal_live');
        
        $estatus = [];

        if ($request->pagosRechazados == true) {
            $estatus[] = 'Rechazado';
        }
        if ($request->pagosPagados == true) {
            $estatus[] = 'Pagado';
        }
        if ($request->pagosPendientes == true) {
            $estatus[] = 'Por Pagar';
        }
        if ($request->pagosAnomalías == true) {
            $estatus[] = 'Anomalia';
        }


        $seg = Pago::query();

        if (isset($request->cobro_int)) {
            $seg->whereHas('contrato', function($query) use ($request){
                $divisa = 'USD';
                
                return  $query->whereIn('estatus', ['viajado', 'comprado', 'Comprado'])->where('divisa', $divisa);
            });
        }else{  
            $seg->whereHas('contrato', function($query) use ($request){
                $divisa = (isset($request->cobro_int)) ? 'UDS' : 'MXN';
                
                $query->when($request->nomina && $request->terminal && !$request->viaserfin, function($q) use($divisa){
                    return  $q->where('pago_con_nomina', 1)->orwhere('via_serfin', 0)->where('divisa', $divisa);
                });

                $query->when($request->nomina && !$request->terminal && $request->viaserfin, function($q) use($divisa){
                    return  $q->where('pago_con_nomina', 1)->orWhere('via_serfin', 1)->where('divisa', $divisa);
                });

                $query->when($request->nomina && !$request->terminal && !$request->viaserfin, function($q) use($divisa){
                    return  $q->where('pago_con_nomina', 1)->where('divisa', $divisa);
                });

                $query->when(!$request->nomina && !$request->terminal && $request->viaserfin, function($q) use($divisa){
                    return $q->where('via_serfin', 1)->where('sys_key', '<>', null)->where('divisa', $divisa);
                });

                $query->when(!$request->nomina && $request->terminal && !$request->viaserfin, function($q) use($divisa){
                    return $q->where(['pago_con_nomina' => 0, 'via_serfin' => 0])->where('divisa', $divisa);
                });

                $query->when(!$request->nomina && $request->terminal && $request->viaserfin, function($q) use($divisa){
                    return $q->where('pago_con_nomina', 0)->where('divisa', $divisa);
                }); 

                $query->when(!$request->nomina && !$request->terminal && !$request->viaserfin, function($q) use($divisa){
                    return $q->where(['pago_con_nomina' => 1, 'via_serfin' => 1])->where('divisa', $divisa);
                });

                return  $query->whereIn('estatus', ['viajado', 'comprado', 'Comprado']);
            });
        }

        // $seg->whereHas('contrato', function($query) use ($request){
        //     $divisa = (isset($request->cobro_int)) ? 'UDS' : 'MXN';

        //     return $query->toSql();
        // });
        $seg->whereHas('contrato.convenio', function($query) use ($request){
            $pais = $request->paise_id;
            $conv = $request->convenio_id;
            
            $query->when($request->paise_id != null, function($q) use ($pais){
                return $q->where('paise_id', $pais);
            });

            $query->when($request->convenio_id != null, function($q) use ($conv){
                return $q->whereIn('id', $conv);
            });
        });

        // if ($request->tipo_tarjeta) {  
        //     $seg->whereHas('contrato.tarjeta', function($query) use ($request){
        //         return $query->where('tipo', $request->tipo_tarjeta);
        //     });
        // }

        $seg->where('cantidad', '>', 0)
        ->whereIn('estatus', $estatus)
        ->whereBetween('fecha_de_cobro', [$request->fecha_inicio, $request->fecha_fin]);

       
        $datos =  $seg->orderBy('segmento', 'ASC')->paginate()->appends($request->query());


        // dd($datos);

        return view('admin.cobranza.index', compact('datos'));
        // return view('admin.cobranza.terminal_live', compact('datos'));
    }


    public function buzon()
    {
        return view('admin.cobranza.serfin.index');
    }

    /**
     * Mostramos la vista para exportar contratos.
     *
     * @return \Illuminate\Http\Response
     */
    public function showExportar(Request $request)
    {
        // $this->get_contratos_exportar();
        $this->authorize('view', Cobranza::class);
        return view('admin.cobranza.exportar');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cargar_archivo()
    {
        $this->authorize('view', Cobranza::class);
        return view('admin.cobranza.serfin.cargar_archivo');
        //
        /**
         * 2da opcion
         */
        // return view('admin.cobranza.terminal');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function get_data(Request $request)
    {

        $segmentos_data = $this->get_data_terminal($request);

        // dd($segmentos_data);

        $data = array();
        $sfr                 = '';
        $index = 1;

        foreach ($segmentos_data as $pago) {

            $pagos_contrato = Pago::where('contrato_id', $pago->contrato_id)->where('cantidad' , '!=' ,0)->get();
            /**
             * Obtenemos la tarjeta asociada al contrato
             */
            if ($pago->tarjeta_id) {
                $tarjeta = Tarjeta::where('id', $pago->tarjeta_id)->first();
                $tarjeta_info = "<span>".$tarjeta->numeroTarjeta."</span><br><small>". $tarjeta->vence ." | ". $tarjeta->verCvv ."</small><br><small>".$tarjeta->tipo." | ".$tarjeta->r_banco->title."</small>";
            }else{
                $tarjeta_info = "<span> N/A </span>";
            }            

            $segmentos = '<div class="text-justify">';
            foreach ($pagos_contrato as $cp) {
                switch ($cp->estatus) {
                  case 'Pagado':
                      $class = 'btn-success';
                      break;
                  case 'Rechazado':
                      $class = 'btn-danger';
                      break;
                  default:
                      $class = 'btn-inverse';
                      break;
                }      
                $active = ($cp->id == $pago->id) ? ' active' : '';
                $segmentos .= '<button class="mytooltip btn btn-xs btnsmall '.$class . $active .'" id="statusPago'.$cp->id.'"><span class="tooltip-item">'.$cp->segmento.'</span> <span class="tooltip-content clearfix"><span class="tooltip-text">'.$cp->segmento .' | '. $cp->fecha_de_cobro .' | '. number_format($cp->cantidad,2,'.','') .'</span></span></button>';
            }
            $segmentos .= '</div>';

            switch ($pago->estatus) {
                case 'Pagado':
                    $class = 'success';
                    break;
                case 'Rechazado':
                    $class = 'danger';
                    break;
                case 'Anomalias':
                    $class = 'info';
                    break;
                default:
                    $class = 'inverse';
                    break;
            }
            
            $btn = '<button class="btn btn-success btn-xs mr-1" value="' . $pago->id . '" data-pago_id="' . $pago->id . '" data-contrato_id="' . $pago->contrato_id . '" id="btnEditarPago" type="button"><i class="fas fa-edit"></i></button>';
            $btn .= '<button class="btn btn-info btn-xs mr-1" data-pago_id="' . $pago->id . '" data-tarjeta_id="' . '' . '" data-contrato_id="' . $pago->contrato_id . '" id="btnMetodoPago" data-route="' . route('contrato.show_metodo_pago', $pago->contrato_id) . '" type="button"><i class="fas fa-arrows-alt-h"></i></button>';

            // $btn .= '<button class="btn btn-dark btn-xs" data-pago_id="' . $pago->id . '" data-tarjeta_id="' . '' . '" data-contrato_id="' . $pago->contrato_id . '" id="btnUpdate" type="button"><i class="fas fa-cog"></i></button>';


            $data[] = array(
                "1" => '<span class="text-capitalize"><button type="button" id="btnPago" data-pago_id="' . $pago->id . '"  data-index="' . $index . '" data-user_id="' . $pago->user_id . '"  data-contrato_id="' . $pago->contrato_id . '" class="btn btn-dark btn-xs">Segmento: ' . $pago->segmento . '</button> </span><br/><small>' . $pago->id . ' </small>',

                "2" => '<span><a class="" href="' . route('users.show', $pago->user_id) . '" target="_blank">' . $pago->cliente . ' </a> <br>' . $pago->empresa_nombre . '</span><br>'. $segmentos,
                
                "3" => '<span id="cantidadPago'.$pago->id.'">' . $pago->divisa .number_format($pago->cantidad, 2) . '</span><br/><small>De: ' . $pago->divisa . number_format($pago->precio_de_compra, 2) . ' </small>',

                "4" => '<button class="btn btn-xs btn-' . $class . '  btnMostratPagos estatusPago' . $pago->id . '"  data-id="all"  id="estatusPago' . $pago->id . '" value="' . $pago->contrato_id . '">' . $pago->estatus . '</button><br/><small>'.$this->obtener_serfin($pago->id).' </small>',

                "5" => '<span id="fechaCobro'.$pago->id.'">' . $pago->fecha_de_cobro . '</span><br/><small id="fechaPago'.$pago->id.'">' . $pago->fecha_de_pago . ' </small>',
                
                "6" => $btn,

                "7" => '<span><a class="" href="' . route('users.show', $pago->user_id) . '" target="_blank"> # ' . $pago->contrato_id . ' </a><br/>' . $pago->sys_key . '</span>',
                "8" => $tarjeta_info,
            );
            $btn = '';
            $index++;
        }
        $results = array(
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "aaData"               => $data,
        );

        return response()->json($results);
    }

    public function obtener_serfin($pago)
    {
        $pago = Pago::findOrFail($pago);
        $sfr = '';
        $sfr .= '<ul class="list-unstyled" style="font-size:10px;">';
        if ($pago->concepto == 'Enganche') {
            $sfr .= '<li>' . $pago->concepto . '</li>';
        }
        if ($pago->created_by) {
            $sfr .= '<li> Creado por: ' . $pago->created_by . '</li>';
        }
        foreach ($pago->historial_desc as $key => $historial) {
            $sfr .= '<li>' . $historial->motivo_del_rechazo . '</li>';
        }
        $sfr .= '</ul>';

        return $sfr;
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-12
     * Descripcion: Generamos la session para poder mostrar la informacino de las tarjetas de los clientes
     */
    public function unlock(Request $request)
    {
        $data['success'] = false;
        if ($request->unlock == $this->unlock_key) {
            session()->put('unlock_cards', true);
            $data['success'] = true;
        }

        return response()->json($data);
    }

    public function validar_pago(Request $request)
    {

        $tarjetas     = Tarjeta::where('user_id', $request->user_id)->get();
        $contrato     = Contrato::where('id', $request->contrato_id)->first();
        $pago         = Pago::findOrFail($request->pago_id);
        $data['view'] = view('admin.cobranza.elementos.validar_pago', compact('tarjetas', 'contrato', 'pago'))->render();

        return response()->json($data);
    }

    public function autorizar_pago($id)
    {

        // dd($id);
        $data['success'] = false;
        $pago            = Pago::where('id', $id)->first();

        $pago->estatus       = 'Pagado';
        $pago->fecha_de_pago = Carbon::now()->format('Y-m-d');
        $pago->cobrador      = Auth::user()->id;

        if ($pago->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    public function rechazar_pago(Request $request, $id)
    {

        $data['success']     = false;
        $pago                = Pago::where('id', $id)->first();
        $pago->estatus       = 'Rechazado';
        $pago->fecha_de_pago = Carbon::now()->format('Y-m-d');
        $pago->cobrador      = Auth::user()->id;

        if ($pago->save()) {
            // $this->card->editar_estatus($request->tarjeta_id, $request->motivo_del_rechazo);
            
            $tarjeta = Tarjeta::findOrFail($request->tarjeta_id);
            if ($tarjeta) {
                $tarjeta->estatus  = $request->motivo_del_rechazo;
                $tarjeta->modified = Carbon::now();
                $tarjeta->save();
            }

            $this->create_srf($pago, $request->motivo_del_rechazo);
            $data['success'] = true;
        }

        return response()->json($data);
    }

    private function create_srf($pago, $motivo_del_rechazo)
    {

        $data['success'] = false;

        $srf = new Serfinrespuestas;

        $srf->contrato_id        = $pago->contrato_id;
        $srf->pago_id            = $pago->id;
        $srf->resultado          = 'Devuelto';
        $srf->cantidad           = $pago->cantidad;
        $srf->created            = $this->now;
        $srf->fecha_de_respuesta = $this->now->format('Y-m-d');
        $srf->motivo_del_rechazo = $motivo_del_rechazo;

        if ($srf->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-30
     * Cargamos los contratos que aun no han sido procesados a serfin
     * @return [type] [description]
     */
    public function get_contratos_exportar()
    {

        $contratos = $this->contratos_nuevos();
        // dd($contratos->get());
        return Datatables::eloquent($contratos)
            ->addColumn('folio_data', function ($contratos) {
                return $contratos->id;
            })
            ->addColumn('clave_opt', function ($contratos) {
                return $contratos->sys_key;
            })
            ->addColumn('fecha_compra_data', function ($contratos) {
                return $contratos->created;
            })
            ->addColumn('cliente_data', function ($contratos) {
                return ($contratos->cliente) ? $contratos->cliente->fullName : 'N/A';
            })
            ->addColumn('tarjeta_data', function ($contratos) {
                return ($contratos->tarjeta) ? $contratos->tarjeta->unlockCard() : 'N/A';
            })
            ->addColumn('tarjetahambiente_data', function ($contratos) {
                return ($contratos->tarjeta) ? $contratos->tarjeta->name : 'N/A';
            })

            ->addColumn('tipo_data', function ($contratos) {
                return ($contratos->tarjeta) ? $contratos->tarjeta->tipo : 'N/A';
            })

            ->addColumn('banco_data', function ($contratos) {
                return ($contratos->tarjeta) ? $contratos->tarjeta->r_banco->title : 'N/A';
            })
            ->rawColumns([
                'folio_data',
                'clave_opt',
                'fecha_compra_data',
                'cliente_data',
                'tarjeta_data',
                'tarjetahambiente_data',
                'tipo_data',
                'banco_data',
            ])
            ->make(true);
    }

    public function generar_opt()
    {
        try {

            $via_serfin_int = Configuracion::where('name', 'via_serfin_int')->first();
            $via_serfin_str = Configuracion::where('name', 'via_serfin_str')->first();
            $cadena         = $via_serfin_str->data;
            $consecutivo    = $via_serfin_int->data;

            $contratos             = $this->contratos_nuevos()->get();
            $data['num_contratos'] = count($contratos);
            $cont                  = 0;

            foreach ($contratos as $contrato) {
                if (empty($contrato->sys_key)) {
                    $consecutivo++;
                    $opt = $cadena . $consecutivo;

                    $log = $this->generar_log($opt);
                    
                    $new_syskey = Contrato::where('id', $contrato->id)
                        ->update([
                            'sys_key' => $opt,
                            'log'     => $log,
                        ]);
                    $cont++;
                }
            }
            $via_serfin_int->data = $consecutivo;
            $via_serfin_int->save();
            $data['success'] = true;

        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }

        return response()->json($data);
    }


    public function generar_log($opt)
    {
        $log = "\n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
        $log .= "## **sys_key**: \n";
        $log .= "+ **  **\n";
        $log .= "+ **$opt**\n";
        $log .= "* * * \n\n";

        return $log;

    }

    public function filtrado_cobranza()
    {

        $this->authorize('view', Cobranza::class);
        return view('admin.cobranza.filtrados');
    }

    /**
     * 
     */
    public function filtrado_sin_segmentos(Request $request)
    {
        $data['success'] = true;

        try {
            $this->drop_table();
            $this->create_table_temp();
            $this->create_table_temp2();
            $this->create_table_temp3();
            $this->create_table_temp4();
            $this->create_table_temp5();
            $this->create_table_temp6();

            $datos        = $this->obtener_filtrado_cero($request->cantidad);
            $data['name'] = 'SinSegmento-' . str_replace(' ', '-', Carbon::now()) . '.xlsx';
            $excel        = Excel::store(new SinSegmento($datos), $data['name'], 'filtrados');
            $data['url']  = route('cobranza.download_sin_segmento', $data['name']);
            $data['cont'] = count($datos);

        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }

        return response()->json($data);
    }

    public function download_sin_segmento($name)
    {
        return response()->download(public_path() . "/files/filtrados/" . $name);
    }

    /**
     *
     */
    public function filtrado_serfin(Request $request)
    {
        $data['success'] = true;
        try {
            $datos = $this->filtrado_serfin_data($request);
            $data['name'] = 'Serfin-' . str_replace(' ', '-', Carbon::now()) . '.xlsx';
            $excel        = Excel::store(new FiltradoSerfin($datos), $data['name'], 'filtrados');
            // dd($excel);            
            $data['url']  = route('cobranza.download_serfin', $data['name']);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }
        return response()->json($data);
    }    


    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-27
     * Obtiene el filtrado de folios suspendidos con la cantidad ingresada a mandar a cobro
     */
    public function filtrado_suspendidos(Request $request)
    {
        // dd($request->all());
        $data['success'] = true;
        try {
            $datos = $this->filtrado_suspendidos_data($request);
            // dd($datos);
            $data['name'] = 'Suspendidos-' . str_replace(' ', '-', Carbon::now()) . '.xlsx';
            $excel        = Excel::store(new FiltradoSerfin($datos), $data['name'], 'filtrados');
            $data['cont'] = count($datos);
            $data['url']  = route('cobranza.download_serfin', $data['name']);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }
        return response()->json($data);
    }

    /**
     *
     */
    public function filtrado_bancomer(Request $request)
    {
        $data['success'] = true;
        try {
            $datos = $this->filtrado_bancomer_data($request);
            $data['name'] = 'BBVA-' . str_replace(' ', '-', Carbon::now()) . '.csv';
            $excel        = Excel::store(new BBVAExport($datos), $data['name'], 'filtrados');
            $data['url']  = route('cobranza.download_serfin', $data['name']);
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }
        return response()->json($data);
    }


    /**
     *
     */
    public function download_serfin($name)
    {
        return response()->download(public_path() . "/files/filtrados/" . $name);
    }

    public function filtrado_doble(Request $request)
    {
        try {
            $data['success'] = true;
            $query           = $this->get_filtrado_doble($request);
            if ($query != null) {
                $file        = "CobranzaDoble" . Carbon::now() . '.xlsx';
                $excel       = Excel::store(new CobranzaDobleExport($query), $file, 'cobranza_doble');
                $data['url'] = route('cobranza.download_file', $file);
            } else {
                $data['success'] = false;
            }

        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();

        }
        return response()->json($data);
    }

    public function download_file($archivo)
    {
        return response()->download(public_path() . '/files/cobranza_doble/' . $archivo);
    }

    public function filtrado_doble_clientes(Request $request)
    {
        // dd($request->all());
        try {
            $data['success'] = true;
            $query           = $this->get_filtrado_clientes($request);
            if ($query != null) {
                $file        = "ClientesDoble" . Carbon::now() . '.xlsx';
                $excel       = Excel::store(new ClientesExport($query), $file, 'cobranza_doble');
                $data['url'] = route('cobranza.download_file', $file);
            } else {
                $data['success'] = false;
            }

        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }
        return response()->json($data);
    }

    public function filtrado_doble_clientes_terminal(Request $request)
    {
        try {
            $data['success'] = true;
            $query = $this->filtrado_terminal($request);
            if ($query != null) {
                $file        = "ContratosTerminal" . Carbon::now() . '.xlsx';
                $excel       = Excel::store(new ClientesTerminalExport($query), $file, 'cobranza_doble');
                $data['url'] = route('cobranza.download_file', $file);
            } else {
                $data['success'] = false;
            }
        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }
        return response()->json($data);
    }



    public function historico()
    {
        return view('admin.cobranza.serfin.historico');
    }
}
