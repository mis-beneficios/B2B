<?php

namespace App\Http\Controllers;

use App\Comision;
use App\Contrato;
use App\Convenio;
use App\Helpers\ComisionesHelper;
use App\Jobs\ProcesarComisiones;
use App\User;
use Auth;
use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Log;
use Storage;
use Yajra\DataTables\Facades\DataTables;

class ComisionController extends Controller
{
    private $comis;
    public function __construct()
    {
        $this->middleware('auth');
        $this->comis = new ComisionesHelper;
        ini_set('max_execution_time', 600); //300 seconds = 5 minutes
    }

    /**
     * Validacion de formulario para listar comisiones
     * Autor: Diego Enrique Sanchez
     * Creado: 2023-12-18
     * @param  Request $request
     * @return validacion
     */
    public function validar_form(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'ejecutivos' => 'required',
            'fechas'     => 'required',
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

        if (Auth::user()->role == 'conveniant') {
            $convenios = Convenio::where('user_id', Auth::id())->get();
        } else {
            $convenios = false;
        }

        if (Auth::user()->role == 'supervisor') {
            $ejecutivos = User::whereIn('role', ['sales', 'supervisor'])->whereIn('salesgroup_id', [Auth::user()->salesgroup_id])->get();
        } else {
            $ejecutivos = User::whereIn('role', ['sales', 'supervisor'])->get();
        }

        return view('admin.comisiones.index', compact('convenios', 'ejecutivos'));
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
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function show(Comision $comision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function edit(Comision $comision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comision $comision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comision  $comision
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comision $comision)
    {
        //
    }

    public function listar_comisiones__(Request $request)
    {

        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        // Validacion de datos ingresados por el usuario
        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        try {
            $fechas       = explode(' al ', $request->fechas);
            $fecha_inicio = $fechas[0];
            $fecha_fin    = $fechas[1];

            $roles = array('admin', 'control', 'supervisor');

            if ($request->ejecutivos) {
                $ejecutivos = implode(',', $request->ejecutivos);
            }

            /**
             * obtencion de datos mediante el Helper Comisiones
             * Evita controlador sobre cargado
             * Diego Enrique Sanchez
             * @var [type]
             */
            // $comisiones = $this->comis->getComisiones_($fecha_inicio, $fecha_fin, $request->ejecutivos);
            $comisiones = $this->comis->getComisiones($fecha_inicio, $fecha_fin, $ejecutivos);

            // dd($fecha_inicio, $fecha_fin, $ejecutivos, $comisiones);
            $data = array();
            $i    = 1;
            $btn  = '';

            foreach ($comisiones as $comision) {
                // $estatus = $this->obtener_estatus_comision($comision->estatus, $comision->motivo_rechazo);
                $data[] = array(
                    "0"  => '<a href="' . route('users.show', $comision->user_id) . '" target="_blank">' . $comision->id . '</a>',
                    "1"  => $comision->tipo_llamada,
                    "2"  => $comision->fecha_de_venta,
                    "3"  => $comision->primer_pago,
                    "4"  => '<span>' . $comision->comisionista . '</span><br><small>' . $comision->vendedor . '</small>',
                    "5"  => $comision->equipo,
                    "7"  => "<span>$comision->cliente_nombre<span> <br> <small class='badge badge-info'>$comision->empresa_nombre</small>",
                    "8"  => $this->obtener_estatus_comision($comision->estatus, $comision->motivo_rechazo),
                    "9"  => $comision->modified,
                    "10" => '$ ' . $comision->cantidad,
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
        } catch (\Exception $e) {
            $results['exceptions'] = $e->getMessage();
        }

        return response()->json($results);
    }

    public function listar_comisiones(Request $request)
    {
        Artisan::call('optimize:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');

        $fechas       = explode(' al ', $request->fechas);
        $fecha_inicio = $fechas[0];
        $fecha_fin    = $fechas[1];

        $roles = array('admin', 'control', 'supervisor');

        if ($request->ejecutivos) {
            $ejecutivos = implode(',', $request->ejecutivos);
        }

        /**
         * obtencion de datos mediante el Helper Comisiones
         * Evita controlador sobre cargado
         * Diego Enrique Sanchez
         * @var [type]
         */
        // $comisiones = $this->comis->getComisiones_($fecha_inicio, $fecha_fin, $request->ejecutivos);
        $comisiones = $this->comis->getComisiones($fecha_inicio, $fecha_fin, $ejecutivos);

        return DataTables::of($comisiones)
            ->editColumn('id', function ($comisiones) {
                return '<a href="' . route('users.show', $comisiones->user_id) . '" target="_blank">' . $comisiones->id . '</a>';
            })
            ->editColumn('comisionista', function ($comisiones) {
                return '<span>' . $comisiones->comisionista . '</span><br><small>' . $comisiones->vendedor . '</small>';
            })
            ->editColumn('cliente_nombre', function ($comisiones) {
                return "<span>$comisiones->cliente_nombre<span> <br> <small class='badge badge-info'>$comisiones->empresa_nombre</small>";
            })
            ->editColumn('estatus', function ($comisiones) {
                switch ($comisiones->estatus) {
                    case 'Pagable':
                    case 'Pagado':
                        $estatus = '<span class="badge badge-success">Pagable</span><br><small>' . $comisiones->motivo_rechazo . '</small>';
                        break;

                    case 'Pagada':
                        $estatus = '<span class="badge badge-info">Pagada</span><br><small>' . $comisiones->motivo_rechazo . '</small>';
                        break;

                    case 'Finiquitadas':
                    case 'Finiquitada':
                        $estatus = '<span class="badge badge-primary">Finiquitada</span><br><small>' . $comisiones->motivo_rechazo . '</small>';
                        break;

                    case 'Rechazada':
                    case 'Rechazado':
                        $estatus = '<span class="badge badge-danger">Rechazada</span><br><small>' . $comisiones->motivo_rechazo . '</small>';
                        break;

                    default:
                        $estatus = '<span class="badge badge-warning">Pendiente</span><br><small>' . $comisiones->motivo_rechazo . '</small>';
                        break;
                }

                return $estatus;
            })
            ->editColumn('cantidad', function ($comisiones) {
                return '$ ' . $comisiones->cantidad;
            })
            ->rawColumns(['id', 'comisionista', 'cliente_nombre', 'estatus', 'cantidad'])
            ->make(true);
    }

    public function obtener_estatus_comision($estatus_comision, $srt = null)
    {
        switch ($estatus_comision) {
            case 'Pagable':
            case 'Pagado':
                $estatus = '<span class="badge badge-success">Pagable</span><br><small>' . $srt . '</small>';
                break;

            case 'Pagada':
                $estatus = '<span class="badge badge-info">Pagada</span><br><small>' . $srt . '</small>';
                break;

            case 'Finiquitadas':
            case 'Finiquitada':
                $estatus = '<span class="badge badge-primary">Finiquitada</span><br><small>' . $srt . '</small>';
                break;

            case 'Rechazada':
            case 'Rechazado':
                $estatus = '<span class="badge badge-danger">Rechazada</span><br><small>' . $srt . '</small>';
                break;

            default:
                $estatus = '<span class="badge badge-warning">Pendiente</span><br><small>' . $srt . '</small>';
                break;
        }

        return $estatus;
    }

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-13
     * Llamamos la clade "ExportVentas" para generar el archivo excel con el filtrado de ventas solicitadas por el usuario
     * @param  Request $request
     * @return response json
     */
    public function exportFiltrado(Request $request, $id = null)
    {
        // try {
        $data['success'] = false;

        $fechas       = explode(' al ', $request->fechas);
        $fecha_inicio = $fechas[0];
        $fecha_fin    = $fechas[1];

        $roles = array('admin', 'control', 'supervisor');
        if (in_array(Auth::user()->role, $roles)) {
            $ejecutivos = implode(',', $request->ejecutivos);
        } else {
            // $ejecutivos = Auth::user()->username;
            /* codigo aaron */
            $ejecutivos = "'" . Auth::user()->username . "'";
        }

        $proceso = ProcesarComisiones::dispatch($fecha_inicio, $fecha_fin, $ejecutivos, $id)->onQueue('filter');

        if ($proceso != null) {
            $data['success'] = true;
            $data['message'] = 'El proceso se está ejecutando en segundo plano, te avisaremos cuando el archivo este listo.';
        }

        return response()->json($data);
        // return redirect()->back()->with('success', 'El proceso se está ejecutando en segundo plano.');

    }

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

    /**
     * Actualizacion de comisiones manual
     * @return 0
     */
    public function show_comisiones()
    {

        $data['success'] = false;
        $contratos       = Contrato::with('comisiones')->whereHas('convenio', function ($query) {
            $query->where('paise_id', 1);
        })
            ->whereNotIn('estatus', ['nuevo', 'suspendido', 'cancelado', 'sin_aprobar'])
            ->whereIn('estatus_comisiones', ['sin_procesar'])
            ->where('comisiones_actualizadas', false)
            // ->whereYear('created','>=', 2023)
            ->orderBy('id', 'ASC')
            ->limit(500)
            ->get();

        foreach ($contratos as $contrato) {
            $pagos        = $contrato->pagos()->where('cantidad', '!=', 0.0)->where('segmento', '!=', 0);
            $numSegmentos = $pagos->count();
            $primerPago   = $pagos->first();

            // echo 'Contrato: '. $contrato->id . '  ------------  Estatus: '.$contrato->estatus.'<br>'.$numSegmentos.' <br>' .$primerPago;
            // echo "<br>";
            // echo "<br>";
            /**
             * Validamos las comisiones por quincena
             * && $numSegmentos <= 25 || $numSegmentos >= 34
             */
            if ($numSegmentos >= 23 && $numSegmentos <= 42) {
                // echo "Quincenal";
                $com = $contrato->validarComisionQuincenal($primerPago);
                // print_r($com);
            } else

                /**
                 * Validamos las comisiones por semana
                 */
                if ($numSegmentos >= 47 && $numSegmentos <= 49 || $numSegmentos >= 71 && $numSegmentos <= 73) {
                    // echo "semanal";
                    $com = $contrato->validarComisionSemanal($primerPago);
                    // print_r($com);
                } else

                    /**
                     * Validamos las comisiones por mes
                     */
                    if ($numSegmentos >= 11 && $numSegmentos <= 13 || $numSegmentos >= 17 && $numSegmentos <= 19) {
                        // echo "Mensual";
                        $com = $contrato->validarComisionMensual($primerPago);
                        // print_r($com);
                    } else {
                        // echo "No definido";
                        $com = $contrato->validarComisionQuincenal($primerPago);
                        // print_r($com);
                    }

            // echo "<br>";
            // echo "<br>";
        }

        Log::info('Se han actualizado:' . count($contratos) . ' comisiones.');
        if (count($contratos) != 0) {
            $data['success']          = true;
            $data['com_actualizadas'] = count($contratos);
        }

        return response()->json($data);
    }

    public function listarComisiones__(Request $request)
    {
        $fechas       = explode(' al ', $request->fechas);
        $fecha_inicio = $fechas[0];
        $fecha_fin    = $fechas[1];

        DB::flushQueryLog();
        $data_comisiones = DB::table('comisiones')
            ->join('users', 'comisiones.user_id', '=', 'users.id')
            ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
            ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
            ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
            ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
            ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
            ->select(
                'contratos.id',
                'contratos.tipo_llamada',
                'contratos.created as fecha_de_venta',
                DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
                DB::raw('min(pagos.estatus) as estatus_pago'),
                DB::raw('min(pagos.segmento) as segmento_pago'),
                'pagos.id as pago_id',
                DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
                DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
                'convenios.empresa_nombre',
                'vendedor.title as vendedor',
                'comisiones.cliente_nombre',
                'comisiones.estatus',
                'comisiones.motivo_rechazo',
                'comisiones.modified',
                'comisiones.cantidad',
                'comisiones.campana_inicio',
                'comisiones.campana_fin',
                'contratos.user_id as user_id',
                'comisiones.id as comision_id',
                'contratos.tipo_pago'
            )
            ->whereIn('users.username', $request->ejecutivos)
            ->whereIn('users.role', ['supervisor', 'sales', 'conveniant'])
            ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
            ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'")
            ->where(function ($query) {
                $query->whereNotIn('comisiones.estatus', ['Finiquitadas'])
                    ->where('pagos.estatus', 'Pagado');
            })
            ->orWhere(function ($query) {
                $query->whereNotIn('comisiones.estatus', ['Finiquitadas', 'Pagable'])
                    ->whereIn('pagos.estatus', ['Rechazado']);
            })
            ->orWhere(function ($query) {
                $query->whereNotIn('comisiones.estatus', ['Finiquitadas', 'Pagable', 'Pendiente', 'Pagada'])
                    ->whereIn('pagos.estatus', ['Por Pagar']);
            })
            ->orderBy('comisionista')
            ->orderBy('empresa_nombre')
            ->paginate(20);
        return view('admin.comisiones.listar-comisiones', compact('data_comisiones'));
        // dd($data_comisiones);
    }

    public function listarComisiones(Request $request)
    {
        $fechas       = explode(' al ', $request->fechas);
        $fecha_inicio = $fechas[0];
        $fecha_fin    = $fechas[1];

        // dd($request->all(), $request->fechas, $request->ejecutivos);
        $resultado1 = DB::table('comisiones')
            ->join('users', 'comisiones.user_id', '=', 'users.id')
            ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
            ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
            ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
            ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
            ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
            ->select(
                'contratos.id',
                'contratos.tipo_llamada',
                'contratos.created as fecha_de_venta',
                DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
                DB::raw('min(pagos.estatus) as estatus_pago'),
                DB::raw('min(pagos.segmento) as segmento_pago'),
                'pagos.id as pago_id',
                DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
                DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
                'convenios.empresa_nombre',
                'vendedor.title as vendedor',
                'comisiones.cliente_nombre',
                'comisiones.estatus',
                'comisiones.motivo_rechazo',
                'comisiones.modified',
                'comisiones.cantidad',
                'comisiones.campana_inicio',
                'comisiones.campana_fin',
                'contratos.user_id as user_id',
                'comisiones.id as comision_id',
                'contratos.tipo_pago'
            )
            ->whereNotIn('comisiones.estatus', ['Finiquitadas'])
            ->where('pagos.estatus', 'Pagado')
            ->whereIn('users.username', $request->ejecutivos)
            // ->whereNotIn('pagos.segmento', [0])
            ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
            ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'");

        $resultado2 = DB::table('comisiones')
            ->join('users', 'comisiones.user_id', '=', 'users.id')
            ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
            ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
            ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
            ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
            ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
            ->select(
                'contratos.id',
                'contratos.tipo_llamada',
                'contratos.created as fecha_de_venta',
                DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
                DB::raw('min(pagos.estatus) as estatus_pago'),
                DB::raw('min(pagos.segmento) as segmento_pago'),
                'pagos.id as pago_id',
                DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
                DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
                'convenios.empresa_nombre',
                'vendedor.title as vendedor',
                'comisiones.cliente_nombre',
                'comisiones.estatus',
                'comisiones.motivo_rechazo',
                'comisiones.modified',
                'comisiones.cantidad',
                'comisiones.campana_inicio',
                'comisiones.campana_fin',
                'contratos.user_id as user_id',
                'comisiones.id as comision_id',
                'contratos.tipo_pago'
            )
            ->whereNotIn('comisiones.estatus', ['Finiquitadas', 'Pagable'])
            ->whereIn('pagos.estatus', ['Rechazado'])
            ->whereIn('users.username', $request->ejecutivos)
            ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
            ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'");

        $data_comisiones = DB::table('comisiones')
            ->join('users', 'comisiones.user_id', '=', 'users.id')
            ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
            ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
            ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
            ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
            ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
            ->select(
                'contratos.id',
                'contratos.tipo_llamada',
                'contratos.created as fecha_de_venta',
                DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
                DB::raw('min(pagos.estatus) as estatus_pago'),
                DB::raw('min(pagos.segmento) as segmento_pago'),
                'pagos.id as pago_id',
                DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
                DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
                'convenios.empresa_nombre',
                'vendedor.title as vendedor',
                'comisiones.cliente_nombre',
                'comisiones.estatus',
                'comisiones.motivo_rechazo',
                'comisiones.modified',
                'comisiones.cantidad',
                'comisiones.campana_inicio',
                'comisiones.campana_fin',
                'contratos.user_id as user_id',
                'comisiones.id as comision_id',
                'contratos.tipo_pago'
            )
            ->whereNotIn('comisiones.estatus', ['Finiquitadas', 'Pagable', 'Pendiente', 'Pagada'])
            ->whereIn('pagos.estatus', ['Por Pagar'])
            ->whereIn('users.username', $request->ejecutivos)
            ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
            ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'")
            ->union($resultado1)
            ->union($resultado2)
            ->orderBy('comisionista')
            ->orderBy('empresa_nombre')
            ->paginate(20);

        return view('admin.comisiones.listar-comisiones', compact('data_comisiones'));
    }
}
