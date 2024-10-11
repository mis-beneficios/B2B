<?php

/**
 * Autor: Isw. Diego Enrique Sanchez
 * Controlamos los accesos a paneles de cada rol asi como funciones que se usan en mas de un rol
 */
namespace App\Http\Controllers;

use App\Actividad;
use App\ActualizarSerfin;
use App\Comision;
use App\Concal;
use App\Contrato;
use App\Convenio;
use App\Exports\ExportVentas;
use App\Padre;
use App\Pago;
use App\Pais;
use App\Salesgroup;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Log;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['profile'])->only('dashboard');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'client') {
            return view('cliente.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $start = microtime(true);
        if (Auth::user()->role != 'admin') {
            abort(403);
        }

        $contratos = Contrato::whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        });
        
        $users = User::whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        });

        $grafica = DB::table('contratos as c')
            ->select(DB::raw('count(c.id) as ventas'), DB::raw('date(c.created) as fecha'))
            ->join('convenios as con', 'c.convenio_id', 'con.id')
            ->whereIn('c.estatus', ['por_autorizar', 'comprado'])
            ->whereYear('c.created', date('Y'))
            ->whereMonth('c.created', date('m'))
            ->groupBy('fecha')
            ->get();

        $ventas_equipo = DB::table('contratos as c')
            ->select(DB::raw('count(c.id) as ventas'), DB::raw('e.title as equipo'))
            ->join('convenios as con', 'c.convenio_id', 'con.id')
            ->join('padres as p', 'c.padre_id', 'p.id')
            ->join('users as u', 'p.user_id', 'u.id')
            ->join('salesgroups as e', 'u.salesgroup_id', 'e.id')
            ->whereIn('c.estatus', ['por_autorizar', 'comprado'])
            ->where(DB::raw('date(c.created)'), date('Y-m-d'))
            ->groupBy('equipo')
            ->get();

        $pagado = Pago::where('estatus', 'Pagado')
            ->where('fecha_de_pago', date('Y-m-d'))
            ->sum('cantidad');

        $actualizacion = ActualizarSerfin::whereCreado(date('Y-m-d'))->first();

        $panel = array(
            'por_autorizar' => $contratos->where('estatus', 'por_autorizar')->count(),
            'contratos_hoy' => $contratos->where('created', '>=', date('Y-m-d'))->count(),
            'clientes'      => $users->where('created', '>=', date('Y-m-d'))->where('role', 'client')->count(),
            'pagado'        => number_format($pagado, 2),
            'actualizacion' => $actualizacion,
        );
        $end = microtime(true);
        $executionTime = $end - $start;
        
        return view('admin.dashboard', compact('grafica', 'panel', 'ventas_equipo'));
    }

    public function dashboard_ventas()
    {

        // if (Auth::user()->role != 'sales') {
        //     abort(403);
        // }

        $padre_id   = Padre::where('user_id', Auth::id())->first()->id;
        $users      = User::where('padre_id', $padre_id)->count();
        $contratos  = Contrato::where('padre_id', $padre_id)->count();
        $comisiones = Comision::where('user_id', Auth::id())->count();

        $ventas_equipo = DB::table('contratos as c')
            ->select(DB::raw('count(c.id) as ventas'), DB::raw('concat(u.nombre," ", u.apellidos) as vendedor'))
            ->join('convenios as con', 'c.convenio_id', 'con.id')
            ->join('padres as p', 'c.padre_id', 'p.id')
            ->join('users as u', 'p.user_id', 'u.id')
            ->join('salesgroups as e', 'u.salesgroup_id', 'e.id')
            ->whereIn('c.estatus', ['por_autorizar', 'comprado'])
            ->where(DB::raw('date(c.created)'), date('Y-m-d'))
            ->where('u.salesgroup_id', Auth::user()->salesgroup_id)
            ->groupBy('c.padre_id', 'vendedor')
            ->get();

        $mis_ventas = DB::table('contratos as c')
            ->select(DB::raw('count(c.id) as ventas'), DB::raw('date(c.created) as fecha'))
            ->join('convenios as con', 'c.convenio_id', 'con.id')
            ->join('padres as p', 'c.padre_id', 'p.id')
            ->join('users as u', 'p.user_id', 'u.id')
            ->join('salesgroups as e', 'u.salesgroup_id', 'e.id')
            ->whereIn('c.estatus', ['por_autorizar', 'comprado'])
            ->where('c.padre_id', $padre_id)
            ->whereYear('c.created', date('Y'))
            ->groupBy('fecha')
            ->get();

        return view('admin.dashboard_ventas', compact('users', 'contratos', 'comisiones', 'ventas_equipo', 'mis_ventas'));
    }

    public function dashboard_cobranza()
    {
        if (Auth::user()->role != 'collector') {
            abort(403);
        }
        $grafica = DB::table('contratos as c')
            ->select(DB::raw('count(c.id) as ventas'), DB::raw('date(c.created) as fecha'))
            ->join('convenios as con', 'c.convenio_id', 'con.id')
            ->whereIn('c.estatus', ['por_autorizar', 'comprado'])
            ->whereYear('c.created', date('Y'))
            ->whereMonth('c.created', date('m'))
            ->groupBy('fecha')
            ->get();

        $ventas_equipo = DB::table('contratos as c')
            ->select(DB::raw('count(c.id) as ventas'), DB::raw('e.title as equipo'))
            ->join('convenios as con', 'c.convenio_id', 'con.id')
            ->join('padres as p', 'c.padre_id', 'p.id')
            ->join('users as u', 'p.user_id', 'u.id')
            ->join('salesgroups as e', 'u.salesgroup_id', 'e.id')
            ->whereIn('c.estatus', ['por_autorizar', 'comprado'])
            ->where(DB::raw('date(c.created)'), date('Y-m-d'))
            ->groupBy('equipo')
            ->get();


        $actualizacion = ActualizarSerfin::whereCreado(date('Y-m-d'))->first();

        $panel = array(
            'actualizacion' => $actualizacion,
        );

        // return view('admin.dashboard_cobranza', compact('panel'));
        return view('admin.dashboard_cobranza', compact('grafica', 'panel', 'ventas_equipo'));

    }

    public function dashboard_reservaciones()
    {

        $this->authorize('dashboard', Reservacion::class, Auth::user());

        $data = DB::select("SELECT paises.id, paises.title as paise_title, regiones.id, regiones.title
        , SUM(case reservaciones.estatus when 'Nuevo' then 1 else 0 end) as NC
        , SUM(case reservaciones.estatus when 'Ingresada' then 1 else 0 end) as NR
        , SUM(case reservaciones.estatus when 'En proceso' then 1 else 0 end) as EP
        , SUM(case reservaciones.estatus when 'Cupon Enviado' then 1 else 0 end) as CE
        , SUM(case reservaciones.estatus when 'Cancelada' then 1 else 0 end) as CA
        , SUM(case reservaciones.estatus when 'Penalizada' then 1 else 0 end) as PN
        , SUM(case reservaciones.estatus when 'Revision' then 1 else 0 end) as RE
        , SUM(case reservaciones.estatus when 'Autorizada' then 1 else 0 end) as OK
        , SUM(case reservaciones.estatus when 'Seguimiento' then 1 else 0 end) as SG -- nuevo estatus DE seguimiento
        FROM paises
        INNER JOIN regiones on paises.id = regiones.paise_id
        INNER JOIN reservaciones on regiones.id = reservaciones.regione_id
        group by paises.id, regiones.title
        order by paises.id, regiones.title;");

        $fecha    = date('Y-m-d');
        $padre_id = Auth::user()->id;

        $pagos_pendientes = DB::select("SELECT r.id AS FOLIO_RESERVACION,
        UPPER(CONCAT (u.nombre, ' ',u.apellidos)) AS NOMBRE_CLIENTE,
        u.id AS ID_CLIENTE,
        p.user_id AS ID_EJECUTIVO,
        p.title AS CORREO_EJECUTIVO,
        UPPER( CONCAT (u2.nombre, ' ',u2.apellidos)) AS NOMBRE_EJECUTIVO,
        r.estatus AS ESTATUS_RESERVACION,
        r.admin_fecha_para_liquidar AS FECHA_LIQUIDAR_HOTEL,
        r.cantidad_pago AS TARIFA_HOTEL,
        r.destino AS DESTINO,
        r.hotel AS HOTEL
        FROM reservaciones  r
        INNER JOIN users u  ON u.id= r.user_id
        INNER JOIN padres p ON p.id= r.padre_id
        INNER JOIN users u2 ON u2.id = p.user_id
        WHERE estatus IN ('en proceso')
        AND admin_fecha_para_liquidar IS NOT NULL
        AND DATE(r.admin_fecha_para_liquidar) = DATE_ADD(DATE('{$fecha}'),INTERVAL 6 DAY)
        and p.user_id = '{$padre_id}'
        AND r.cantidad_pago > 0
        ORDER BY r.id"
        );

        // dd($pagos_pendientes);
        $ejecutivos = User::whereRole('reserver')->get();

        return view('admin.dashboard_reservas', compact('data', 'ejecutivos', 'pagos_pendientes'));
    }

    public function dashboard_convenios()
    {

        $convenios              = Convenio::where('user_id', Auth::id())->get();
        $panel['num_convenios'] = $convenios->count();
        $sum                    = 0;
        foreach ($convenios as $con) {
            $sum += count($con->contratos);
        }
        $panel['ventas_total'] = $sum;
        $panel['actividades']  = Actividad::where('user_id', Auth::id())->count();
        $panel['seguimientos'] = Concal::where('user_id', Auth::id())->count();
        $panel['comisiones']   = Comision::where('user_id', Auth::id())->count();

        // dd($panel);
        return view('admin.dashboard_convenios', compact('panel'));
    }

    public function dashboard_control()
    {

        // if (Auth::user()->role != 'control' || Auth::user()->role != 'quality') {
        //     abort(403);
        // }

        $contratos = Contrato::whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        });
        $users = User::whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        });

        $grafica = DB::table('contratos as c')
            ->select(DB::raw('count(c.id) as ventas'), DB::raw('date(c.created) as fecha'))
            ->join('convenios as con', 'c.convenio_id', 'con.id')
            ->whereYear('c.created', date('Y'))
            ->whereMonth('c.created', date('m'))
            ->groupBy('fecha')
            ->get();

        $panel = array(
            'por_autorizar' => $contratos->where('estatus', 'por_autorizar')->count(),
            'contratos_hoy' => $contratos->where('created', '>=', date('Y-m-d'))->count(),
            'clientes'      => $users->where('created', '>=', date('Y-m-d'))->count(),
        );

        // dd($panel);

        return view('admin.dashboard_control', compact('panel', 'grafica'));
    }

    public function dashboard_quality()
    {
        return view('admin.dashboard_cobranza');
    }

    public function dashboard_reserver()
    {
        return view('admin.dashboard_cobranza');
    }

    public function dashboard_conveniant()
    {
        return view('admin.dashboard_cobranza');
    }

    public function buscar_usuario($data)
    {
        $busqueda = trim($data);
        $opt      = strtolower(trim($busqueda, "0123456789"));

        $pre = substr(strtolower($busqueda), 0, 2);

        // dd($busqueda, $opt, $pre);

        if (substr($data, -1) == '.') {
            $busqueda = substr($data, 0, -1);
            $opt      = '.';
            $users    = DB::table('users as u')
                ->join('contratos as con', 'u.id', 'con.user_id')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'con.id as txt_busqueda')
                ->where('con.id', $busqueda)
            // ->orwhere('con.sys_key', 'like', '%' . $texto . '%')
                ->groupBy('u.id')
                ->get();
            // dd($users);
        } else if (is_numeric($busqueda) || is_numeric(str_replace(" ", "", $busqueda))) {
            $opt   = 'numerico';
            $users = DB::table('users as u')
                ->join('contratos as con', 'u.id', 'con.user_id')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'u.userName as txt_busqueda')
                ->where('con.id', 'like', '%' . $busqueda . '%')
                ->orWhere('u.telefono', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('u.telefono_casa', 'LIKE', '%' . $busqueda . '%')
                ->orWhere('u.telefono_oficina', 'LIKE', '%' . $busqueda . '%')
                ->get();

        } else if ($opt == 'opt') {
            $opt   = 'opt';
            $users = DB::table('users as u')
                ->join('contratos as con', 'u.id', 'con.user_id')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'u.userName as txt_busqueda')
                ->where('con.sys_key', $busqueda)
                ->get();

        } else if ($opt == 'tar' || $opt == 't') {
            $opt   = 'tar';
            $texto = substr($busqueda, -4);
            $users = DB::table('users as u')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->join('tarjetas as t', 'u.id', 't.user_id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 't.numero as txt_busqueda')
                ->where(DB::raw("substring(t.numero, 13,5)"), 'like', '%' . $texto)
                ->groupBy('u.id')
                ->get();

        } else if ($pre == 'f:') {
            $opt   = $pre;
            $texto = trim(str_replace('f:', '', trim($data)));
            $users = DB::table('users as u')
                ->join('contratos as con', 'u.id', 'con.user_id')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'con.id as txt_busqueda')
                ->where('con.id', 'like', '%' . $texto . '%')
                ->groupBy('u.id')
                ->get();

        } else if ($pre == 'u:') {
            $opt = $pre;

            $texto = trim(str_replace('u:', '', trim($data)));
            $term  = explode(' ', $texto);

            $conditionsR = array();
            foreach ($term as $str) {
                $conditionsR[] = array($str);
            }

            $users = DB::table('users as u')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'u.userName as txt_busqueda')
                ->where(DB::raw('concat(LTRIM(u.nombre)," ", LTRIM(u.apellidos))'), 'LIKE', "%" . $texto . "%")
                ->orWhereIn(DB::raw('concat(LTRIM(u.nombre)," ", LTRIM(u.apellidos))'), [$conditionsR])
                ->orwhere(DB::raw('LTRIM(u.nombre)'), 'LIKE', "%" . $texto . "%")
                ->orWhere(DB::raw('LTRIM(u.apellidos)'), 'LIKE', "%" . $texto . "%")

                ->orwhereIn(DB::raw('LTRIM(u.nombre)'), [$conditionsR])
                ->orWhereIn(DB::raw('LTRIM(u.apellidos)'), [$conditionsR])

                ->orWhere('u.username', 'LIKE', "%" . $texto . "%")
                ->orWhere('u.telefono', 'LIKE', "%" . $texto . "%")
                ->orWhere('u.telefono_casa', 'LIKE', "%" . $texto . "%")
                ->orWhere('u.telefono_oficina', 'LIKE', "%" . $texto . "%")
                ->groupBy('u.id')
                ->get();

        } else if ($pre == 't:') {
            $opt   = $pre;
            $texto = str_replace('t:', '', trim($data));
            $users = DB::table('users as u')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->join('tarjetas as t', 'u.id', 't.user_id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 't.numero as txt_busqueda')
                ->where(DB::raw("substring(t.numero, 13,5)"), 'like', '%' . $texto)
                ->groupBy('u.id')
                ->get();

        } else if ($pre == 'r:') {
            $opt   = $pre;
            $texto = str_replace('r:', '', $data);
            $term  = explode(' ', $texto);

            $conditionsR = array();
            foreach ($term as $str) {
                $conditionsR[] = array($str);
            }
            // dd($opt, $texto, $term, $conditionsR);

            $users = DB::table('users as u')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->join('reservaciones as r', 'u.id', 'r.user_id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'r.nombre_de_quien_sera_la_reservacion as txt_busqueda')
                ->where('r.nombre_de_quien_sera_la_reservacion', 'like', '%' . $texto . '%')
                ->orWhereIn('r.nombre_de_quien_sera_la_reservacion', $term)
                ->orWhereIn('r.nombre_de_quien_sera_la_reservacion', $conditionsR)
                ->groupBy('u.id')
                ->get();

            // dd($users);
        } else if ($pre == 'n:') {
            $opt   = $pre;
            $texto = str_replace('n:', '', $data);
            $users = DB::table('users as u')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->join('reservaciones as r', 'u.id', 'r.user_id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'r.nombre_de_quien_sera_la_reservacion as txt_busqueda')
                ->where('r.id', $texto)
                ->groupBy('u.id')
                ->get();

        } else if ($pre == 'c:') {
            $opt   = $pre;
            $texto = str_replace('c:', '', trim($data));

            // dd($opt, $texto, trim($texto));
            $users = DB::table('users as u')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->join('reservaciones as r', 'u.id', 'r.user_id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'r.nombre_de_quien_sera_la_reservacion as txt_busqueda')
                ->where('r.clave', trim($texto))
                ->orWhere('r.clave', 'like', trim($texto) . '%')
                ->groupBy('u.id')
                ->get();

        } else {
            $opt   = 'libre';
            $users = DB::table('users as u')
                ->join('convenios as c', 'u.convenio_id', 'c.id')
                ->select(DB::raw("concat(u.nombre, ' ', u.apellidos) as cliente"), 'u.id', 'u.username', 'c.empresa_nombre', 'u.userName as txt_busqueda')
                ->orwhere(DB::raw('concat(LTRIM(RTRIM(u.nombre))," ", LTRIM(RTRIM(u.apellidos)))'), 'LIKE', "%" . $data . "%")
                ->orwhere(DB::raw('LTRIM(RTRIM(u.nombre))'), 'LIKE', "%" . $data . "%")
                ->orWhere(DB::raw('LTRIM(RTRIM(u.apellidos))'), 'LIKE', "%" . $data . "%")
                ->orWhere('u.username', 'LIKE', "%" . $data . "%")
                ->groupBy('u.id')
                ->get();
        }

        $data = array();
        $i    = 1;
        $btn  = '';
        foreach ($users as $val) {
            $data[] = array(
                // "convenio" => ($val->empresa_nombre) ? $val->empresa_nombre : 'Sin convenio',
                "convenio"     => $val->empresa_nombre,
                "usuario"      => $val->cliente,
                "username"     => $val->username,
                'btn'          => '<a href="' . route('users.show', $val->id) . '" type="button" class="btn btn-info btn-xs">Ver</a>',
                'txt_busqueda' => $val->txt_busqueda,
            );
            $btn = '';
        }

        //DEVUELVE LOS DATOS EN UN JSON
        $results = array(
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"               => $data,
            "input_comparativo"    => $data,
        );
        return response()->json($results);
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Cambial color de sistema administrativo
     * @param  [int] $color
     * @return [json] $data
     */
    public function cambiar_color($color)
    {
        setcookie('color_system', $color, time() + 60 * 60 * 24 * 60, '/');
        Log::debug('Usuario: ' . Auth::user()->username . ' (' . Auth::user()->fullName . ') ' . 'cambio de color a: ' . $color);
        $data['success'] = true;
        return response()->json($data);
    }

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-09
     * Lanzamos la vista y los convenios para poder realizar la busqueda bajo convenios seleccionados
     * @return $convenios
     */
    public function viewVentas()
    {

        $this->authorize('ver_ventas', Auth::user());
        $convenios = Convenio::where('paise_id', env('APP_PAIS_ID', 1))->get(['empresa_nombre', 'id']);
        $equipos   = Salesgroup::all();
        $paises    = Pais::all();
        // dd($convenios);
        return view('admin.elementos.views.ventas', compact('convenios', 'equipos', 'paises'));
    }

    /**
     * Autor: Isw Diego Sanchez
     * Creado: 2022-06-10
     * Listado de ventas dentro de la vista ventas datatables
     * @param  Request $request
     * @return response json
     */
    public function filtrarVentas(Request $request)
    {
        $total_ventas = $this->getDataFiltrado($request);
        // dd($total_ventas);
        $data = array();
        $i    = 1;
        $btn  = '';

        foreach ($total_ventas as $venta) {
            if ($venta->pagos_realizados != 0) {
                $colorPagos = 'info';
            } else {
                $colorPagos = 'danger';
            }

            $data[] = array(
                "0"  => '<a class="btn btn-dark btn-xs" href="' . route('users.show', $venta->user_id) . '" role="button">' . $venta->id . '</a>',
                "1"  => ($venta->cliente) ? $venta->cliente->fullName : 'N/A',
                "2"  => $venta->paquete,
                "3"  => '<span class="label" style="background: ' . $venta->color_estatus() . '">' . $venta->estatus . '</span>',
                "4"  => $venta->padre->vendedor->fullName,
                "5"  => ($venta->padre->vendedor->equipo) ? $venta->padre->vendedor->equipo->title : 'Sin registro',
                "6"  => '<span class="label label-info">' . $venta->cuotas_pagos . '</span>',
                "7"  => '<span class="label label-' . $colorPagos . '">' . $venta->pagos_realizados . '</span>',
                "8"  => $venta->diffForhumans(),
                "9"  => $venta->convenio->empresa_nombre,
                "10" => $venta->tipo_llamada,
                "11" => $venta->ComoSeEntero,
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

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-13
     * Llamamos la clade "ExportVentas" para generar el archivo excel con el filtrado de ventas solicitadas por el usuario
     * @param  Request $request
     * @return response json
     */
    public function exportFiltrado(Request $request)
    {
        try {
            $ventas          = $this->getDataFiltrado($request);
            $data['name']    = 'Ventas-' . str_replace(' ', '-', Carbon::now()) . '.xlsx';
            $data['success'] = true;
            $excel           = Excel::store(new ExportVentas($ventas), $data['name'], 'filtrados');
            $data['url']     = route('ventas.download', $data['name']);

        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();

        }

        return response()->json($data);

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
        return response()->download(public_path() . "/files/filtrados/" . $name);
    }

    /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-13
     * Consilta para obtener el filtrado de las ventas solicitadas por el usuario
     * se usa en mas de un metodo, revisar la modificacion en metodo @exportFiltrado y @downloadFiltrado
     * @param  Request $request
     * @return array data
     */
    public function getDataFiltrado($request)
    {

        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin    = $request->fecha_fin;
        $ventas       = Contrato::whereBetween(DB::raw('date(created)'), [$fecha_inicio, $fecha_fin])
            ->with(['cliente', 'tarjeta', 'padre', 'tarjeta.r_banco', 'padre.vendedor'])
            ->whereHas('convenio', function ($q) {
                $q->where('paise_id', env('APP_PAIS_ID'));
            })
            ->withCount(['pagos as cuotas_pagos'])
            ->withCount(['pagos as pagos_realizados' => function ($query) {
                $query->where('estatus', 'Pagado');
            }]);

        if ($request->convenio_id) {
            $ventas->whereHas('convenio', function ($q) use ($request) {
                $q->where('id', $request->convenio_id);
            });
        }
        // if ($request->pais_id) {
        //     $ventas->whereHas('convenio', function ($q) use ($request) {
        //         $q->where('paise_id', $request->pais_id);
        //     });
        // }
        if ($request->estatus) {
            $ventas->whereIn('estatus', $request->estatus);
        }

        if ($request->tipo_llamada) {
            $ventas->whereIn('tipo_llamada', $request->tipo_llamada);
        }

        if ($request->como_se_entero) {
            $ventas->whereHas('cliente', function ($q) use ($request) {
                $q->whereIn('como_se_entero', $request->como_se_entero);
            });
        }

        if ($request->equipo) {
            $ventas->whereHas('padre.vendedor', function ($q) use ($request) {
                $q->whereIn('salesgroup_id', $request->equipo);
            });
        }

        $ventas_total = $ventas->groupBy('id')->orderBy('id')->get();
        return $ventas_total;
    }

    public function get_ingresos($rango_fechas)
    {

        $fecha_request = explode(' al ', $rango_fechas);

        $fechaIngreso = Carbon::parse($fecha_request[0])->format('Y-m-d');
        $fechaSalida  = Carbon::parse($fecha_request[1])->format('Y-m-d');

        $data['ingresos'] = DB::table('pagos')
            ->select(DB::raw("sum(cantidad) as cantidad"), DB::raw("date(fecha_de_pago) as fecha"))
            ->whereBetween('fecha_de_pago', [$fechaIngreso, $fechaSalida])
            ->where('estatus', 'Pagado')
            ->groupBy('fecha_de_pago')
            ->orderBy('fecha', 'ASC')
            ->get();

        return response()->json($data);
    }

}
