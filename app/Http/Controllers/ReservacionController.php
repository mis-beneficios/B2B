<?php

namespace App\Http\Controllers;

use App;
use App\Contrato;
use App\ContratosReservaciones as CR;
use App\Estancia;
use App\Exports\FiltradoReservaciones;
use App\Habitacion;
use App\Helpers\LogHelper;
use App\Helpers\SmsHelper;
use App\Mail\Mx\EnviarCuponConfirmacion;
use App\Mail\Mx\EnviarCuponPago;
use App\Padre;
use App\Region;
use App\Reservacion;
use App\Tarjeta;
use App\Traits\ReservacionTrait;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use Excel;
use Illuminate\Http\Request;
use Log;
use Mail;
use Yajra\DataTables\Facades\DataTables;

class ReservacionController extends Controller
{
    use ReservacionTrait;
    private $log;

    public function __construct()
    {
        $this->log = new LogHelper;
        $this->middleware('auth');
        $this->sms = new SmsHelper;

    }

    /**
     * Validacion de formulario para crear reservacion
     * Autor: Diego Enrique Sanchez
     * Creado: 2022-10-18
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_form(Request $request, $method = 'POST', $user = null)
    {
        $validator = \Validator::make($request->all(), [
            'titular'     => 'required | string | max:60',
            'destino'     => 'required | string',
            'estancia_id' => 'required',
            // 'habitaciones' => 'required',
        ]);
        return $validator;
    }

    /**
     * Autor: Diego Enrique Sanchez
     * Creado: 2022-12-06
     * Validacion de formulario para los ajustes de la reservacion seleccionada
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_form_ajustes(Request $request, $method = 'POST', $user = null)
    {
        $validator = \Validator::make($request->all(), [
            'tarifa'   => 'numeric|min:0',
            'cantidad' => 'numeric|min:0',
            // 'clave'     => 'required',
        ]);
        return $validator;
    }
    /**
     * Autor: Diego Enrique Sanchez
     * Creado: 2022-12-06
     * Validacion de formulario para los ajustes de la reservacion seleccionada
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_form_pagos(Request $request, $method = 'POST', $user = null)
    {

        $validator = \Validator::make($request->all(), [
            'cantidad_pago'             => ($request->cantidad_pago != 0) ? 'numeric|min:0' : '',
            'cantidad_pago_1'           => ($request->cantidad_pago_1 != 0) ? 'numeric|min:0' : '',
            'cantidad_pago_2'           => ($request->cantidad_pago_2 != 0) ? 'numeric|min:0' : '',
            'cantidad_pago_3'           => ($request->cantidad_pago_3 != 0) ? 'numeric|min:0' : '',
            'admin_fecha_para_liquidar' => (isset($request->cantidad_pago) && $request->cantidad_pago != 0) ? 'required' : '',
            'fecha_de_pago_1'           => (isset($request->cantidad_pago_1) && $request->cantidad_pago_1 != 0) ? 'required' : '',
            'fecha_de_pago_2'           => (isset($request->cantidad_pago_2) && $request->cantidad_pago_2 != 0) ? 'required' : '',
            'fecha_de_pago_3'           => (isset($request->cantidad_pago_3) && $request->cantidad_pago_3 != 0) ? 'required' : '',

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

        $ejecutivos = User::whereRole('reserver')->get();

        return view('admin.reservaciones.index', compact('data', 'ejecutivos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $estancias = Estancia::where(['habilitada' => 1, 'estancia_paise_id' => env('APP_PAIS_ID')])->select('id', 'title', 'precio', 'habilitada', 'descripcion', 'noches', 'adultos', 'ninos', 'divisa', 'cuotas')->orderBy('id', 'DESC')->get();

        $tarjetas = Tarjeta::where('user_id', $user->id)->get();

        $contratos = Contrato::whereIN('estatus', ['Comprado', 'Pagado', 'Tarjeta con problemas', 'viajado'])->where('user_id', $user->id)->get();

        return view('admin.reservaciones.create', compact('user', 'estancias', 'tarjetas', 'contratos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $fecha           = Carbon::now();
        $data['success'] = false;
        $padre_id        = Padre::where('user_id', Auth::user()->id)->first()->id;
        $validate        = $this->validar_form($request);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        try {

            $fecha_request = explode(' al ', $request->fechas);

            // dd($fecha_request);

            $fechaIngreso = Carbon::parse($fecha_request[0])->format('Y-m-d');
            $fechaSalida  = Carbon::parse($fecha_request[1])->format('Y-m-d');

            $noches = Carbon::parse($fechaIngreso)->diffInDays(Carbon::parse($fechaSalida));

            $estancia = Estancia::findOrFail($request->estancia_id);

            $reservacion                                      = new Reservacion;
            $reservacion->nombre_de_quien_sera_la_reservacion = $request->titular;
            $reservacion->title                               = $estancia->title;
            $reservacion->user_id                             = $request->user_id;
            $reservacion->convenio_id                         = $estancia->convenio_id;
            $reservacion->estancia_id                         = $request->estancia_id;
            $reservacion->regione_id                          = $request->regione_id;

            $reservacion->padre_id         = $padre_id;
            $reservacion->created          = $fecha;
            $reservacion->modified         = $fecha;
            $reservacion->estatus          = 'Ingresada';
            $reservacion->destino          = $request->destino;
            $reservacion->tarjeta_id       = $request->tarjeta_id;
            $reservacion->tipo             = $request->tipo_reservacion;
            $reservacion->hotel            = '';
            $reservacion->fecha_de_ingreso = $fechaIngreso;
            $reservacion->fecha_de_salida  = $fechaSalida;
            $reservacion->email            = $request->email;
            $reservacion->telefono         = $request->telefono;
            $reservacion->noches           = $noches;
            $reservacion->dias             = $noches + 1;

            if ($reservacion->save()) {
                $this->log->add_reservacion(Auth::user(), $reservacion);
                $data['success']     = true;
                $data['reservacion'] = $reservacion;
                // $this->validarHabitaciones($reservacion, $request->habitaciones);
            }

        } catch (\Exception $e) {
            $data['errores'] = $e->getMessage();
            $data['success'] = false;

        }

        return response()->json($data);
    }

    public function validarHabitaciones($reservacion, $num_habitaciones)
    {
        try {

            for ($i = 1; $i = $num_habitaciones; $i++) {
                $habitacion                   = new Habitacion();
                $habitacion->user_id          = $reservacion->user_id;
                $habitacion->padre_id         = $reservacion->padre_id;
                $habitacion->estancia         = $reservacion->title;
                $habitacion->reservacione_id  = $reservacion->id;
                $habitacion->noches           = $reservacion->estancia->noches;
                $habitacion->adultos          = $reservacion->estancia->adultos;
                $habitacion->menores          = 0;
                $habitacion->juniors          = 0;
                $habitacion->adultos_extra    = 0;
                $habitacion->menores_extra    = 0;
                $habitacion->fecha_de_ingreso = $reservacion->fecha_de_ingreso;
                $habitacion->fecha_de_salida  = $reservacion->fecha_de_salida;

                $habitacion->save();
            }
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservacion  $reservacion
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        if ($request->ajax()) {
            $data['success'] = true;
            $reservacion     = Reservacion::findOrFail($id);
            // dd($reservacion->contratos);
            $data['view'] = view('admin.reservaciones.show', compact('reservacion'))->render();
            return response()->json($data);
        } else {

            $this->authorize('filter', Reservacion::class);
            // $reservacion = Reservacion::findOrFail($id);
            $reservacion = Reservacion::with(['contratos', 'r_habitaciones'])->findOrFail($id);
            $contratos   = Contrato::whereIN('estatus', ['Comprado', 'Pagado', 'Tarjeta con problemas', 'viajado'])->where('user_id', $reservacion->user_id)->orderBy('id', 'ASC')->get();
            $vinculados  = Reservacion::findOrFail($id)->contratos;
            $user        = User::findOrFail($reservacion->user_id);

            $noches = 0;
            if ($vinculados != null) {
                foreach ($vinculados as $vin) {
                    $noches += $vin->noches;
                }
            }

            return view('admin.reservaciones.ver', compact('reservacion', 'contratos', 'vinculados', 'user', 'noches'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservacion  $reservacion
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        // $this->authorize('update',Auth::user());
        $data['success'] = true;
        $reservacion     = Reservacion::findOrFail($id);
        // dd($reservacion->estancia);
        $data['view'] = view('admin.reservaciones.edit', compact('reservacion'))->render();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservacion  $reservacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['success'] = false;
        $reservacion     = Reservacion::findOrFail($id);
        $temporal        = $reservacion->toArray();

        $fecha_request = explode(' al ', $request->fechas);

        $fechaIngreso = Carbon::parse($fecha_request[0])->format('Y-m-d');
        $fechaSalida  = Carbon::parse($fecha_request[1])->format('Y-m-d');

        $noches = Carbon::parse($fechaIngreso)->diffInDays(Carbon::parse($fechaSalida));

        $reservacion->title                               = $request->title;
        $reservacion->estatus                             = $request->estatus;
        $reservacion->destino                             = $request->destino;
        $reservacion->regione_id                          = $request->regione_id;
        $reservacion->tarjeta_id                          = $request->tarjeta_id;
        $reservacion->estancia_id                         = $request->estancia_id;
        $reservacion->nombre_de_quien_sera_la_reservacion = $request->nombre_adquisitor;
        $reservacion->tipo                                = $request->tipo_reserva;
        $reservacion->fecha_de_ingreso                    = $fechaIngreso;
        $reservacion->fecha_de_salida                     = $fechaSalida;
        $reservacion->email                               = $request->email;
        $reservacion->telefono                            = $request->telefono;
        $reservacion->noches                              = $noches;
        $reservacion->dias                                = $noches + 1;
        // $reservacion->detalle                             = $request->comentarios;

        if ($reservacion->save()) {

            // if (isset($reservacion->getChanges()['estatus'])) {
            /**
             * log para capturar los cambios realizados en el registro de la reservacion
             */
            if (array_diff($reservacion->getChanges(), $temporal) && isset($reservacion->getChanges()['estatus'])) {
                // $this->log->reservacion_log_editar(Auth::user(), $reservacion->getChanges(), $temporal, $reservacion);
                $old_log   = $reservacion->notas;
                $notas_new = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
                $notas_new .= "### **estatus:**: \n";
                $notas_new .= "+ **" . $reservacion->getChanges()['estatus'] . "**\n";
                $notas_new .= "+ **" . $temporal['estatus'] . "** \n";
                $notas_new .= "* * *  \n\n";
                $reservacion->notas = $notas_new . $old_log;
                $reservacion->save();
            }
            // }
            if ($request->comentario) {

                $old_log = $reservacion->notas;

                $notas_new = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
                $notas_new .= "### ** nota: **: \n";
                $notas_new .= "**" . $request->comentario . "** \n \n";
                $notas_new .= "* * * \n";
                $reservacion->notas = $notas_new . $old_log;
                $reservacion->save();
            }
            $data['success'] = true;
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservacion  $reservacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $reservacion         = Reservacion::findOrFail($id);
            $data['reservacion'] = $reservacion;
            $this->deleteAsociacion($id);
            $this->deleteHabitaciones($id);

            $reservacion->delete();
            $data['success'] = true;
        } catch (Exception $e) {
            $data['errors']  = $e;
            $data['success'] = false;
        }

        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado : 2022-08-30
     * Eliminacion de habitaciones en caso de existir vinculadas a una reservacion
     * @param  $id
     * @return bolean
     */
    public function deleteHabitaciones($id)
    {
        try {
            // $habitacion = DB::delete('delete habitaciones where reservacione_id = ?', [$id]);
            $habitacion = DB::table('habitaciones')->where('reservacione_id', $id)->delete();
            $res        = true;
        } catch (Exception $e) {
            $res = false;
        }

        return $res;
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado : 2022-08-30
     * Eliminacion de habitaciones en caso de existir vinculadas a una reservacion
     * @param  $id
     * @return bolean
     */
    public function deleteAsociacion($id)
    {
        try {
            // $res_con = DB::delete('delete contratos_reservaciones where reservacione_id = ?', [$id]);
            $res_con = DB::table('contratos_reservaciones')->where('reservacione_id', $id)->delete();

            $res = true;
        } catch (Exception $e) {
            $res = false;
        }

        return $res;
    }

    /**
     * Listado de reservaciones del cliente
     * Autor: Diego Enrique Sanchez
     * Creado: 2021-11-05
     * @param  [int] $id
     * @return Response $result definido para pintar el datatable
     */
    public function get_reservaciones($id)
    {

        $reservaciones = Reservacion::with(['contratos'])->where('user_id', $id)->get();
        $data          = array();
        $i             = 1;
        $btn           = '';
        $contratos_res = '';

        foreach ($reservaciones as $reservacion) {

            $btnInfo = (Auth::user()->can('bntInfo', $reservacion)) ? '<button class="btn btn-dark btn-xs btnLogReservacion" data-reservacion_id="' . $reservacion->id . '" id="btnLogReservacion" type="button"><i class="fa fa-exclamation-circle"></i></button> <br>' : '';

            $btnInfo .= (Auth::user()->can('delete', $reservacion)) ?
            '<button class="btn btn-danger btn-xs mt-1" data-estatus="' . $reservacion->estatus . '"  data-id="' . $reservacion->id . '" data-placement="top" data-toggle="tooltip" data-user_name="' . $reservacion->cliente->fullName . '" data-username="' . $reservacion->cliente->username . '" id="btnDeleteR" title="Re asignar reservacion"  value="' . $reservacion->id . '"><i class="fas fa-trash"></i></button>'
            : '';

            $contratos_res .= '<strong>' . __('messages.user.show.contratos') . '</strong><ul class="list-unstyled">';
            foreach ($reservacion->contratos as $contratos) {
                $contratos_res .= '<li>' . $contratos->id . '</li>';
            }

            $contratos_res .= '</ul>';

            $ven = ($reservacion->padre) ? $reservacion->padre->title : 'Sin ejecutivo';

            if (Auth::user()->role == 'admin') {
                $padre = "<small class='text-info' style='font-size: 10px'><strong data-id='$reservacion->padre_id' data-reservacion_id='$reservacion->id' id='btnCanbiarEjecutivo'>" . __('messages.user.show.ejecutivo') . " : <br/>$ven</strong></small>";
            } else {
                $padre = "<small class='text-info' style='font-size: 10px'><strong data-id='$reservacion->padre_id' data-reservacion_id='$reservacion->id' id=''>" . __('messages.user.show.ejecutivo') . " : <br/>$ven</strong></small>";
            }

            $noches = intval(Carbon::parse($reservacion->fecha_de_ingreso)->diffInDays(Carbon::parse($reservacion->fecha_de_salida)));
            $dias   = $noches + 1;

            $data[] = array(
                "1" => $btnInfo,
                "2" => $reservacion->id . '<br>' . $contratos_res . $padre,
                "3" => '<label class="label" style="background-color:' . $reservacion->color_estatus() . '">' . $reservacion->estatus . '</label>',
                "4" => $reservacion->fecha_de_ingreso . ' al ' . $reservacion->fecha_de_salida . '<br> <span class="label label-info">' . $noches . ' Noches - ' . $dias . ' Dias </span>',
                "5" => $reservacion->destino,
                "6" => $this->botones_accion($btn, $reservacion),
            );
            $btnInfo       = '';
            $contratos_res = '';
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

    public function listado_global()
    {
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

        return response()->json($data);
    }

    public function botones_accion($btn, $reservacion)
    {

        $btn .= (Auth::user()->can('view', $reservacion)) ? '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '" data-placement="top" data-toggle="tooltip" id="btnShow" title="Ver"  value="' . $reservacion->id . '" href="' . route('reservations.show', $reservacion->id) . '"> <i class="fas fa-eye"></i> Ver </a>' : '';

        $btn .= (Auth::user()->can('update', $reservacion)) ?
        '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '"  data-placement="top" data-toggle="tooltip" data-user_name="' . $reservacion->cliente->fullName . '" data-username="' . $reservacion->cliente->username . '" id="btnEditR" title="Editar"  value="' . $reservacion->id . '" data-url="' . route('reservations.edit', $reservacion->id) . '"><i class="fas fa-edit"></i> Editar </a>'
        : '';

        $btn .= (Auth::user()->can('ajustes_reservacion', $reservacion)) ? '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '" data-placement="top" data-toggle="tooltip" id="btnAjustesR" title="Ajustes de reservacion" data-url="' . route('reservations.infoHotel', $reservacion->id) . '"  value="' . $reservacion->id . '"><i class="fa fa-cog" aria-hidden="true"></i> Ajustes de reservacion </a>' : '';

        $btn .= (Auth::user()->can('pagos', $reservacion)) ? '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '" data-placement="top" data-toggle="tooltip" id="btnPagosR" data-url="' . route('reservations.pagos', $reservacion->id) . '" title="Pagos"  value="' . $reservacion->id . '"> <i class="fas fa-dollar"></i> Pagos </a>' : '';

        $btn .= (Auth::user()->can('cupon_confirmacion', $reservacion)) ? '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '" data-placement="top" data-toggle="tooltip" id="btnCuponCR" title="Pagos" data-url="' . route('reservations.cuponConfirmacion', $reservacion->id) . '"  value="' . $reservacion->id . '"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Cupon de confirmación </a>' : '';

        $btn .= (Auth::user()->can('cupon_cobro', $reservacion)) ? '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '" data-placement="top" data-toggle="tooltip" data-url="' . route('reservations.cuponPago', $reservacion->id) . '" id="btnCuponPR" title="Pagos"  value="' . $reservacion->id . '"> <i class="fa fa-credit-card" aria-hidden="true"></i> Cupon de cobro </a>' : '';

        $btn .= (Auth::user()->can('habitaciones_contratos', $reservacion)) ? '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '" data-placement="top" data-url="' . route('reservations.asociarContrato', $reservacion->id) . '" data-toggle="tooltip" id="btnConfig" title="Enlazar contratos y habitaciones"  value="' . $reservacion->id . '"> <i class="fa fa-cogs" aria-hidden="true"></i> Enlazar contratos y habitaciones </a>' : '';

        // $btn .= (Auth::user()->can('asignar', $reservacion)) ? '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '" data-placement="top" data-toggle="tooltip" id="btnAsignarReserva" title="Asignar"  value="' . $reservacion->id . '" data-type="asignar"  data-toggle="modal" data-target="#modalAsignarReservacion" data-reservacion_id="' . $reservacion->id . '"><i class="fa fa-street-view" aria-hidden="true"></i> Asignar </a>' : '';

        $btn .= (Auth::user()->can('asignar', $reservacion)) ? '<a href="javascript:void(0)" data-type="asignar"  data-toggle="modal" data-target="#modalAsignarReservacion" data-reservacion_id="' . $reservacion->id . '" class="dropdown-item" id="btnAsignarReserva" style="color: black;"><i class="fa fa-street-view" aria-hidden="true"></i> Asignar</a>' : '';

        $btn .= (Auth::user()->can('delete', $reservacion)) ?
        '<a class="dropdown-item" data-estatus="' . $reservacion->estatus . '"  data-id="' . $reservacion->id . '" data-placement="top" data-toggle="tooltip" data-user_name="' . $reservacion->cliente->fullName . '" data-username="' . $reservacion->cliente->username . '" id="btnDeleteR" title="Eliminar reservación"  value="' . $reservacion->id . '"><i class="fas fa-trash"></i> Eliminar</a>'
        : '';

        $btn = '<div class="btn-group">
              <button type="button" class="btn btn-info btn-sm dropdown-toggle drop_2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
              </button>
              <div class="dropdown-menu">
               ' . $btn . '
              </div>
            </div>';

        return $btn;
    }

    public function log_reservacion($id)
    {
        $reservacion     = Reservacion::findOrFail($id);
        $data['success'] = false;
        if ($reservacion) {
            $data['success']   = true;
            $data['historico'] = $reservacion->logReservacion;
        }

        return response()->json($data);
    }

    public function pdf_reserver($id)
    {
        $reservacion = Reservacion::findOrFail($id);
        $pdf         = App::make('dompdf.wrapper');
        $pdf->loadView('admin.reservaciones.elementos.pdf_reserver', compact('reservacion'));
        return $pdf->stream('invoice.pdf');

        // $pdf = Pdf::loadView('admin.reservaciones.show', $reservacion);
        // return $pdf->download('invoice.pdf');
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-05
     * Se muestra la informacion de la reservacion basada a los pagos pendientes en modal
     * @param  [type] $id
     * @return [type] json
     */
    public function pagos($id)
    {
        $data['success'] = true;
        $reservacion     = Reservacion::findOrFail($id);
        // dd($reservacion);
        $data['view'] = view('admin.reservaciones.pagos', compact('reservacion'))->render();
        return response()->json($data);
    }

    public function storePagos(Request $request, $id)
    {

        $validate = $this->validar_form_pagos($request);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        try {
            $data['success'] = false;
            $reservacion     = Reservacion::findOrFail($id);
            $temporal        = $reservacion->toArray();

            $reservacion->pagada                    = $request->pagada;
            $reservacion->estatus                   = $request->estatus;
            $reservacion->admin_fecha_para_liquidar = $request->admin_fecha_para_liquidar;
            $reservacion->tipo                      = $request->tipo_reserva;
            $reservacion->cantidad_pago             = $request->cantidad_pago;
            $reservacion->garantizada               = $request->garantizada;
            $reservacion->garantia                  = $request->garantia;

            // if ($reservacion->cantidad_pago_1 != '0') {
            $reservacion->cantidad_pago_1 = $request->cantidad_pago_1;
            $reservacion->fecha_de_pago_1 = $request->fecha_de_pago_1;
            // }

            // if ($reservacion->cantidad_pago_2 != '0') {
            $reservacion->cantidad_pago_2 = $request->cantidad_pago_2;
            $reservacion->fecha_de_pago_2 = $request->fecha_de_pago_2;
            // }

            // if ($reservacion->cantidad_pago_3 != '0') {
            $reservacion->cantidad_pago_3 = $request->cantidad_pago_3;
            $reservacion->fecha_de_pago_3 = $request->fecha_de_pago_3;
            // }

            if ($reservacion->save()) {
                // if (array_diff($reservacion->getChanges(), $temporal)) {
                //     $this->log->reservacion_log_editar(Auth::user(), $reservacion->getChanges(), $temporal, $reservacion);
                // }
                if (array_diff($reservacion->getChanges(), $temporal) && isset($reservacion->getChanges()['estatus'])) {
                    // $this->log->reservacion_log_editar(Auth::user(), $reservacion->getChanges(), $temporal, $reservacion);
                    $old_log   = $reservacion->notas;
                    $notas_new = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                    $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
                    $notas_new .= "### **estatus:**: \n";
                    $notas_new .= "+ **" . $reservacion->getChanges()['estatus'] . "**\n";
                    $notas_new .= "+ **" . $temporal['estatus'] . "** \n";
                    $notas_new .= "* * *  \n\n";
                    $reservacion->notas = $notas_new . $old_log;
                    $reservacion->save();
                }
                if ($request->comentario) {

                    $old_log = $reservacion->notas;

                    $notas_new = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                    $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
                    $notas_new .= "### ** nota: **: \n";
                    $notas_new .= "" . $request->comentario . " \n";
                    $notas_new .= "* * *  \n";
                    $reservacion->notas = $notas_new . $old_log;
                    $reservacion->save();
                }
                $data['success'] = true;
            }
        } catch (\Exception $e) {
            $data['errores'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /**
     * Autor: ISW. Diego Sanchez
     * Creado: 2022-09-25
     * Creacion de cupon de confirmacion reservacion
     * @param  [int] $id
     * @return [bool] PDF cupon de confirmacion
     */
    public function cuponConfirmacion($id)
    {
        $reservacion = Reservacion::findOrFail($id);
        $date_inicio = Carbon::create($reservacion->fecha_de_ingreso);
        $date_fin    = Carbon::create($reservacion->fecha_de_salida);

        //pax
        $data['pax']    = "";
        $adultos        = 0;
        $menores        = 0;
        $juniors        = 0;
        $edades         = array();
        $edades_juniors = array();

        foreach ($reservacion->r_habitaciones as $key => $habitacion) {
            $adultos = $adultos + $habitacion['adultos'];
            $menores = $menores + $habitacion['menores'];
            $juniors = $juniors + $habitacion['juniors'];

            for ($i = 1; $i <= $habitacion['menores']; $i++) {
                $edades[] = $habitacion['edad_menor_' . $i];
            }

            for ($i = 1; $i <= $habitacion['juniors']; $i++) {
                $edades_juniors[] = $habitacion['edad_junior_' . $i];
            }

        }

        if ($adultos > 0) {
            $data['pax'] .= $adultos . ' Adulto(s)';
        }

        if ($menores > 0) {
            $data['pax'] .= ' / ' . $menores . ' Menor(es) - ' . implode(",", $edades) . ' Años';
        }

        if ($juniors > 0) {
            $data['pax'] .= ' / ' . $juniors . ' Junior(s) - ' . implode(",", $edades_juniors) . ' Años';
        }

        $data['ano'] = $date_inicio->format('Y');
        $meses       = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha       = Carbon::parse($reservacion->fecha_limite_de_pago);
        // $data['mes'] = $meses[($date_inicio->format('n')) - 1];

        // // $data['mes']     = $date_inicio->format('M');
        // $data['entrada'] = $date_inicio->format('d');
        // $data['salida']  = $date_fin->format('d');

        $data['mes']        = $meses[($date_inicio->format('n')) - 1];
        $data['entrada']    = $date_inicio->format('d');
        $data['salida']     = $date_fin->format('d');
        $data['mes_salida'] = $meses[($date_fin->format('n')) - 1];

        // dd($reservacion, $data);
        // dd($adultos, $menores, $juniors, $pax, $ano, $mes, $entrada, $salida);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('admin.reservaciones.cupon_confirmacion', compact('reservacion', 'data'));
        return $pdf->stream('reservacion-' . $reservacion->id . '.pdf');

        // return view('admin.reservaciones.cupon_confirmacion', compact('reservacion', 'data'));

    }

    public function cuponPago($id)
    {
        $reservacion = Reservacion::findOrFail($id);
        $date_inicio = Carbon::create($reservacion->fecha_de_ingreso);
        $date_fin    = Carbon::create($reservacion->fecha_de_salida);

        $meses        = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $fecha        = Carbon::parse($reservacion->fecha_limite_de_pago);
        $mes          = $meses[($fecha->format('n')) - 1];
        $fecha_limite = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');

        $data['mes']        = $meses[($date_inicio->format('n')) - 1];
        $data['entrada']    = $date_inicio->format('d');
        $data['salida']     = $date_fin->format('d');
        $data['mes_salida'] = $meses[($date_fin->format('n')) - 1];

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('admin.reservaciones.cupon_pago', compact('reservacion', 'data', 'fecha_limite'));
        return $pdf->stream('CuponPago-' . $reservacion->id . '.pdf');

        // return view('admin.reservaciones.cupon_pago', compact('reservacion', 'data'));

    }

    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-11-16
     * Muestra el formulario para asociar los folios y agregar habitaciones a la reservacion
     * Relaciones: Reservacion-Habitacion y Reservacion-Contratos
     * @param  [type] $id
     * @return json data
     */
    public function asociarContrato($id)
    {
        $data['success'] = true;
        $reservacion     = Reservacion::with(['contratos', 'r_habitaciones'])->findOrFail($id);
        $contratos       = Contrato::with('reservaciones')->whereIN('estatus', ['Comprado', 'Pagado', 'Tarjeta con problemas', 'viajado'])->where('user_id', $reservacion->user_id)->orderBy('id', 'ASC')->get();
        $vinculados      = $reservacion->contratos;

        if ($reservacion->noches != null) {
            $data['noches'] = $reservacion->noches;
            $data['dias']   = $reservacion->dias;
        } else {
            $noches         = Carbon::parse($reservacion->fecha_de_ingreso)->diffInDays(Carbon::parse($reservacion->fecha_de_salida));
            $data['noches'] = $noches;
            $data['dias']   = $noches + 1;
        }

        // dd($noches);
        $data['view'] = view('admin.reservaciones.asociar_folios', compact('reservacion', 'contratos', 'vinculados'))->render();

        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * creado: 2022-11-14
     * Asocia y registra las habitaciones a la reservacion seleccinada
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function ajustes(Request $request, $id)
    {

        // if (!is_null($request->contrato_id)) {
        try {
            $reservacion     = Reservacion::findOrFail($id);
            $data['success'] = false;

            // if ($request->contrato_id) {
            //     foreach ($request->contrato_id as $folio) {
            //         $cr                  = new CR();
            //         $cr->contrato_id     = $folio;
            //         $cr->reservacione_id = $id;
            //         if ($cr->save()) {
            //             Contrato::where('id', $folio)
            //                 ->update(['estatus' => 'viajado']);
            //         }
            //     }
            // }

            $num_habitaciones = $this->editarHabitaciones($request, $reservacion);
            // $num_habitaciones = $this->registrarHabitaciones($request, $reservacion);

            $data['success']             = true;
            $data['numero_habitaciones'] = $num_habitaciones;
        } catch (\Exception $e) {
            $data['errores'] = $e->getMessage();
        }
        // } else {
        //     $data['success'] = false;
        //     $data['errores'] = 'No se ha seleccionado ningun folio a asociar...';
        // }

        return response()->json($data);
    }

    public function agregarReservacion($user_id)
    {
        try {
            $estancias = Estancia::where(['habilitada' => 1, 'estancia_paise_id' => env('APP_PAIS_ID')])->select('id', 'title', 'precio', 'habilitada', 'descripcion', 'noches', 'adultos', 'ninos', 'divisa', 'cuotas')->orderBy('id', 'ASC')->get();
            $user      = User::findOrFail($user_id);
            $tarjetas  = Tarjeta::where('user_id', $user_id)->get();

            $data['view']    = view('admin.reservaciones.elementos.fromAddReservacion', compact('estancias', 'user', 'tarjetas'))->render();
            $data['success'] = true;

        } catch (Exception $e) {

            $data['success'] = false;
            $data['errors']  = $e;
        }

        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * creado: 2022-11-16
     * Asocia y registra las habitaciones a la reservacion seleccinada
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function editarAjustes(Request $request, $id)
    {
        // dd($request->all());
        $data['success'] = false;
        try {
            $reservacion = Reservacion::findOrFail($id);
            // $vinculados  = CR::where('reservacione_id', $reservacion->id)->get();
            // if ($vinculados) {
            //     foreach ($vinculados as $con) {
            //         Contrato::where('id', $con->contrato_id)
            //                 ->update(['estatus' => 'viajado']);

            //         $con->delete();
            //     }
            // }
            // if (!is_null($request->contrato_id)) {

            //     foreach ($request->contrato_id as $folio) {
            //         // $cr = CR::where('contrato_id', $folio)->first();
            //         $cr                  = new CR();
            //         $cr->contrato_id     = $folio;
            //         $cr->reservacione_id = $id;

            //         if ($cr->save()) {
            //             Contrato::where('id', $folio)
            //                 ->update(['estatus' => 'viajado']);
            //         }
            //     }
            $num_habitaciones            = $this->editarHabitaciones($request, $reservacion);
            $data['success']             = true;
            $data['numero_habitaciones'] = $num_habitaciones;
            // }
            // else {
            //     $data['success'] = false;
            //     $data['errores'] = 'No se ha seleccionado ningun folio a asociar...';
            // }

            if (array_diff($reservacion->getChanges(), $reservacion->toArray()) && isset($reservacion->getChanges()['estatus'])) {
                // $this->log->reservacion_log_editar(Auth::user(), $reservacion->getChanges(), $temporal, $reservacion);
                $old_log   = $reservacion->notas;
                $notas_new = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
                $notas_new .= "### **estatus:**: \n";
                $notas_new .= "+ **" . $reservacion->getChanges()['estatus'] . "**\n";
                $notas_new .= "+ **" . $temporal['estatus'] . "** \n";
                $notas_new .= "* * *  \n\n";
                $reservacion->notas = $notas_new . $old_log;
                $reservacion->save();
            }
        } catch (\Exception $e) {
            $data['errors'] = $e->getMessage();
        }

        return response()->json($data);
    }

    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-04-20
     * Descripcion: vinculamos y desvinculamo el folio seleccionado a la reservacion abierta folio por folio
     */
    public function folio_reservacion($contrato_id, $reservacion_id, $estatus = null)
    {
        $data['success']   = false;
        $data['vinculado'] = false;

        $contrato_vinculado = CR::where(['reservacione_id' => $reservacion_id, 'contrato_id' => $contrato_id])->first();

        if ($contrato_vinculado == null) {
            // Creamos el registro de asociacion de contrato con reservacion
            CR::create(['contrato_id' => $contrato_id, 'reservacione_id' => $reservacion_id]);

            // Cambiamos el estatus del contrato a viajado por que ya se encuentra asociado a una reservacion
            Contrato::where('id', $contrato_id)->update(['estatus' => 'viajado']);

            $data['success']   = true;
            $data['vinculado'] = true;
        } else {
            if ($contrato_vinculado->delete()) {
                Contrato::where('id', $contrato_id)->update(['estatus' => 'comprado']);
                $data['success']      = true;
                $data['desvinculado'] = true;
            }
        }

        return response()->json($data);
    }

    /*
     * Funcionamiento correcto
     */
    // public function editarAjustes(Request $request, $id)
    // {
    //     // dd($request->all());
    //     $data['success'] = false;
    //     try {
    //         $reservacion = Reservacion::findOrFail($id);
    //         $vinculados  = CR::where('reservacione_id', $reservacion->id)->delete();
    //         if (!is_null($request->contrato_id)) {

    //             foreach ($request->contrato_id as $folio) {
    //                 // $cr = CR::where('contrato_id', $folio)->first();
    //                 $cr                  = new CR();
    //                 $cr->contrato_id     = $folio;
    //                 $cr->reservacione_id = $id;

    //                 if ($cr->save()) {
    //                     Contrato::where('id', $folio)
    //                         ->update(['estatus' => 'viajado']);
    //                 }
    //             }
    //             $num_habitaciones            = $this->editarHabitaciones($request, $reservacion);
    //             $data['success']             = true;
    //             $data['numero_habitaciones'] = $num_habitaciones;
    //         } else {
    //             $data['success'] = false;
    //             $data['errores'] = 'No se ha seleccionado ningun folio a asociar...';
    //         }

    //         if (array_diff($reservacion->getChanges(), $temporal) && isset($reservacion->getChanges()['estatus'])) {
    //             // $this->log->reservacion_log_editar(Auth::user(), $reservacion->getChanges(), $temporal, $reservacion);
    //             $old_log   = $reservacion->notas;
    //             $notas_new = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
    //             $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
    //             $notas_new .= "### **estatus:**: \n";
    //             $notas_new .= "+ **" . $reservacion->getChanges()['estatus'] . "**\n";
    //             $notas_new .= "+ **" . $temporal['estatus'] . "** \n";
    //             $notas_new .= "* * *  \n\n";
    //             $reservacion->notas = $notas_new . $old_log;
    //             $reservacion->save();
    //         }
    //     } catch (\Exception $e) {
    //         $data['errors'] = $e->getMessage();
    //     }

    //     return response()->json($data);
    // }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-11-22
     * Obtenermos las reservaciones asignadas al usuario logueado
     * informacion para usuario tipo reservaciones
     * (Modificar codigo para mostrar a usuarios administrativos)
     * @return [type] [description]
     */
    public function misAsignaciones()
    {
        $asignadas = Reservacion::whereIn('estatus', ['Nuevo', 'Ingresada', 'En proceso', 'Revision', 'Autorizada'])
            ->where('padre_id', Auth::user()->admin_padre->id)
            ->orderBy('estatus')
            ->orderBy('fecha_de_ingreso');

        return DataTables::eloquent($asignadas)
            ->addColumn('nombre_add', function ($asignadas) {
                // return '<span class="text-uppercase">' . $asignadas->cliente->fullName . '</span><br><small class="label" style="background: ' . $asignadas->color_estatus() . '">' . $asignadas->estatus . '</small>';
                $username = ($asignadas->email) ? $asignadas->email : $asignadas->cliente->username;
                return '<span class="text-uppercase">' . $asignadas->cliente->fullName . '</span><br><small>' . $username . '</small>';
            })
            ->addColumn('email_add', function ($asignadas) {
                // return ($asignadas->email) ? $asignadas->email : $asignadas->cliente->username;
                return '<small class="label" style="background: ' . $asignadas->color_estatus() . '">' . $asignadas->estatus . '</small>';
            })
            ->addColumn('destino_add', function ($asignadas) {
                return ' <span class="text-wrap">' . $asignadas->destino . '</span><br><small>' . $asignadas->fecha_de_ingreso . ' al ' . $asignadas->fecha_de_salida . '</small>';
            })
            ->addColumn('actions', function ($asignadas) {
                $btn = '';

                $btn .= '<a href="' . route('users.show', $asignadas->user_id) . '"  class="btn btn-dark btn-xs" id="btnEditarAsignacion"><i class="fas fa-edit"></i></a>';

                return $btn;
            })
            ->rawColumns(['nombre_add', 'email_add', 'destino_add', 'info_reserva', 'actions'])
            ->make(true);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-11-22
     * Obtenermos las reservaciones din asignar
     * informacion para usuario tipo reservaciones
     * (Modificar codigo para mostrar a usuarios administrativos)
     * @return [type] [description]
     */
    public function sinAsignar()
    {
        $sin_asignar = Reservacion::whereIn('estatus', ['Nuevo'])
            ->where('padre_id', null)
            ->orWhere('padre_id', 0)
            ->where('regione_id', 1)
            ->where('estatus', '!=', 'Cancelada')
            ->orderBy('estatus')
            ->orderBy('fecha_de_ingreso');

        return DataTables::eloquent($sin_asignar)
            ->addColumn('nombre_add', function ($sin_asignar) {
                $username = ($sin_asignar->email) ? $sin_asignar->email : $sin_asignar->cliente->username;
                return '<span class="text-uppercase">' . $sin_asignar->cliente->fullName . '</span><br><small>' . $username . '</small>';
            })
            ->addColumn('email_add', function ($sin_asignar) {
                return '<small class="label" style="background: ' . $sin_asignar->color_estatus() . '">' . $sin_asignar->estatus . '</small>';
            })
            ->addColumn('destino_add', function ($sin_asignar) {
                return ' <span class="text-wrap">' . $sin_asignar->destino . '</span><br><small>' . $sin_asignar->fecha_de_ingreso . ' al ' . $sin_asignar->fecha_de_salida . '</small>';
            })
            ->addColumn('actions', function ($sin_asignar) {
                $btn = '';
                $btn .= '<a href="javascript:void(0)" data-type="tomar"   data-reservacion_id="' . $sin_asignar->id . '" data-user_id="' . Auth::user()->admin_padre->id . '" class="btn btn-success btn-xs" id="btnTomarReserva"><i class="fas fa-check"></i></a>';

                $btn .= (Auth::user()->can('asignar', $sin_asignar)) ?
                '<a href="javascript:void(0)" data-type="asignar"  data-toggle="modal" data-target="#modalAsignarReservacion" data-reservacion_id="' . $sin_asignar->id . '" class="btn btn-dark btn-xs ml-1" id="btnAsignarReserva"><i class="fas fa-user"></i></a>'
                : '';

                return $btn;
            })
            ->rawColumns(['nombre_add', 'email_add', 'destino_add', 'info_reserva', 'actions'])
            ->make(true);
    }

    public function filtradoReservaciones($region_id = 1, $tipo = null)
    {
        $this->authorize('filter', Reservacion::class);

        $region     = Region::findOrFail($region_id);
        $ejecutivos = User::with(['admin_padre'])->where('role', 'reserver')->get();
        return view('admin.reservaciones.filtrados', compact('region', 'ejecutivos'));
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-03
     * Pinta la informacion de la tabla de las reservaciones filtradas
     * @param  Request $request
     * @return [datatable]
     */
    public function getFiltrado(Request $request)
    {
        // dd($request->all());
        $reservaciones = $this->dataReservaciones($request);
        // dd($reservaciones->get());

        return DataTables::eloquent($reservaciones)
            ->addColumn('folio', function ($reservaciones) {
                return '<a href="' . route('users.show', $reservaciones->user_id) . '"  class="btn btn-link">' . $reservaciones->id . '</a>';

            })
            ->addColumn('cliente', function ($reservaciones) {
                if ($reservaciones->padre_id != null) {
                    $padre = $reservaciones->padre->title;
                } else {
                    $padre = '';
                }

                return (($reservaciones->cliente) ? $reservaciones->cliente->fullName : 'S/R') . '<br><small>' . $padre . '</small>';
            })
            ->editColumn('destino', function ($reservaciones) {
                return strtoupper($reservaciones->destino);
            })
            ->addColumn('paquete', function ($reservaciones) {
                return ($reservaciones->estancia) ? $reservaciones->estancia->title : 'N/A';
            })

            ->editColumn('estatus', function ($reservaciones) {
                return '<small class="label" style="background: ' . $reservaciones->color_estatus() . '">' . $reservaciones->estatus . '</small>';
            })
            ->addColumn('fechas', function ($reservaciones) {
                return '<small>' . $reservaciones->fecha_de_ingreso . '<br>' . $reservaciones->fecha_de_salida . '</small> <br>';
            })

            ->addColumn('pago_info', function ($reservaciones) {
                return '$' . $reservaciones->cantidad . ' MXN' . '<br><small>' . $reservaciones->fecha_limite_de_pago . '</small>';
            })
            ->addColumn('tarifa_info', function ($reservaciones) {
                return '$' . $reservaciones->tarifa . ' MXN' . '<br><small>' . $reservaciones->admin_fecha_para_liquidar . '</small>';
            })
            ->addColumn('pago_final', function ($reservaciones) {

                $pagado      = ($reservaciones->pagada == 1) ? 'Pagada' : 'Pendiente';
                $garantizada = ($reservaciones->garantizada == 1) ? '*' : '';

                return '$' . $reservaciones->cantidad_pago . ' MXN' . '<br><small>' . $pagado . $garantizada . '</small>';
            })

            ->addColumn('actions', function ($reservaciones) {
                $btn = '';
                $btn .= '<a href="' . route('users.show', $reservaciones->user_id) . '"  class="btn btn-dark btn-xs" id="btnAsignarReserva"><i class="fas fa-eye"></i></a>';
                // $btn .= '<a href="javascript:void(0)" data-reservacion_id="' . $sin_asignar->id . '" class="btn btn-success btn-xs ml-1" id="btnAsignarReserva"><i class="fas fa-user"></i></a>';

                return $btn;
            })
            ->rawColumns(['folio', 'cliente', 'destino', 'paquete', 'estatus', 'fechas', 'pago_info', 'tarifa_info', 'pago_final', 'actions'])
            ->make(true);
    }

    /**
     * Autor: Isw Diego Enrique Sanchez
     * Creado: 2022-12-01
     * Consulta general para el fultrado de reservaciones para el panel de reservas
     * @param  [type] $request
     * @return [type] array
     */
    public function dataReservaciones($request)
    {

        $data = Reservacion::with(['cliente', 'padre'])->where('regione_id', $request->region_id);

        if (isset($request->estatus)) {
            $data->whereIn('estatus', $request->estatus);
        }

        if (isset($request->estatus_pago)) {
            $data->whereIn('pagada', $request->estatus_pago);
        }

        if (isset($request->garantia)) {
            $data->whereIn('garantizada', $request->garantia);
        }

        if (isset($request->tipo_reserva)) {
            $data->whereIn('tipo', $request->tipo_reserva);
        }

        if (isset($request->destino)) {
            $data->where('destino', 'like', '%' . $request->destino . '%');
        }

        if (isset($request->hotel)) {
            $data->where('hotel', 'like', '%' . $request->hotel . '%');
        }

        if (isset($request->ingreso)) {
            $data->whereBetween('fecha_de_ingreso', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if (isset($request->alta)) {
            $data->whereBetween('created', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if (isset($request->pago_hotel)) {
            $data->whereBetween('admin_fecha_para_liquidar', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if (isset($request->pago_cliente)) {
            $data->whereBetween('fecha_limite_de_pago', [$request->fecha_inicio, $request->fecha_fin]);
        }

        if (isset($request->ejecutivos)) {
            $data->whereIn('padre_id', $request->ejecutivos);
        }

        // $data->orderBy('fecha_de_ingreso');
        // whereBetween('fecha_de_ingreso', [$request->fecha_inicio, $request->fecha_fin])

        return $data;
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-01
     * Creacion del archivos xls para la exportacion de los datos filtrados por reservaciones
     * @param  Request $request
     * @return [type] json
     */
    public function createFiltrado(Request $request)
    {
        try {
            $data['success'] = true;

            $reservaciones = $this->dataReservaciones($request)->get();
            $data['name']  = 'Reservaciones-' . str_replace(' ', '-', Carbon::now()) . '.xlsx';

            $excel       = Excel::store(new FiltradoReservaciones($reservaciones), $data['name'], 'filtrados', null);
            $data['url'] = route('reservations.downloadFiltrado', $data['name']);

        } catch (\Exception $e) {
            $data['success'] = false;
            $data['errors']  = $e->getMessage();
        }
        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-01
     * Descarga el archivo xls generado con el filtrado de reservaciones
     * @param  [type] $name
     * @return [type] file
     */
    public function downloadFiltrado($name)
    {
        return response()->download(public_path() . "/files/filtrados/" . $name);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-04
     * Toma la reservacion por parte del ejecutivo o el usuario logueado, puede asignarse la reservacion seleccionada
     * @param  [int] $id  id de la reservacion seleccionada
     * @param  [int] $user_id id del usuario que tomara la reservacion
     * @return [json] $data
     */
    public function tomarReservacion($id, $user_id)
    {
        $data['success'] = false;
        $reservacion     = Reservacion::findOrFail($id);

        if ($user_id) {
            $reservacion->padre_id = $user_id;
            $reservacion->save();

            $data['success'] = true;
        }

        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-04
     * Asignacion de reservaciones nuevas a ejecutivos tipo reservacion
     * @param  Request $request
     * @return json  $data
     */
    public function asignarReservacion(Request $request)
    {
        $data['success'] = false;
        $reservacion     = Reservacion::findOrFail($request->reservacion_id);
        if ($reservacion) {
            $reservacion->padre_id = $request->padre_id;
            if ($reservacion->save()) {
                $data['success'] = true;
            }

        }

        return response()->json($data);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2022-12-06
     * Mostramos el formulario para llenar la informacion del hotel y tarifas asociadas a este
     * @param  [int] $id
     * @return [json] $data
     */
    public function infoHotel($id)
    {
        $data['success'] = true;
        $reservacion     = Reservacion::findOrFail($id);
        // dd($reservacion->estancia);
        $data['view'] = view('admin.reservaciones.ajustes', compact('reservacion'))->render();
        return response()->json($data);
    }

    public function storeAjustes(Request $request, $id)
    {

        $validate = $this->validar_form_ajustes($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $data['success'] = false;
        $reservacion     = Reservacion::findOrFail($id);
        $temporal        = $reservacion->toArray();

        $reservacion->estatus                   = $request->estatus;
        $reservacion->hotel                     = $request->hotel;
        $reservacion->contacto                  = $request->contacto;
        $reservacion->tarifa                    = $request->tarifa;
        $reservacion->admin_fecha_para_liquidar = $request->admin_fecha_para_liquidar;
        $reservacion->direccion                 = $request->direccion;
        $reservacion->entrada                   = $request->entrada;
        $reservacion->salida                    = $request->salida;
        $reservacion->clave                     = $request->clave;
        $reservacion->cantidad                  = $request->cantidad;
        $reservacion->fecha_limite_de_pago      = $request->fecha_limite_de_pago;
        $reservacion->detalle                   = $request->detalle;

        if ($reservacion->save()) {
            if (array_diff($reservacion->getChanges(), $temporal) && isset($reservacion->getChanges()['estatus'])) {
                // $this->log->reservacion_log_editar(Auth::user(), $reservacion->getChanges(), $temporal, $reservacion);
                $old_log   = $reservacion->notas;
                $notas_new = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
                $notas_new .= "### **estatus:**: \n";
                $notas_new .= "+ **" . $reservacion->getChanges()['estatus'] . "**\n";
                $notas_new .= "+ **" . $temporal['estatus'] . "** \n";
                $notas_new .= "* * *  \n\n";
                $reservacion->notas = $notas_new . $old_log;
                $reservacion->save();
            }

            if ($request->comentario) {
                $old_log   = $reservacion->notas;
                $notas_new = "\n \n#**" . Auth::user()->fullName . "**, [" . Auth::user()->username . "]: \n";
                $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
                $notas_new .= "### ** nota: **: \n";
                $notas_new .= "" . $request->comentario . " \n";
                $notas_new .= "* * *  \n";
                $reservacion->notas = $notas_new . $old_log;
                $reservacion->save();
            }
            $data['success'] = true;
        }
        return response()->json($data);
    }

    public function enviarConfirmacion(Request $request)
    {
        $res['success'] = false;
        try {
            $cupon = $this->construir_cupon_confirmacion($request->id);
            if ($res) {
                $data['name']   = $cupon['name'];
                $data['file']   = $cupon['file'];
                $data['de']     = $request->de;
                $data['para']   = $request->para;
                $data['asunto'] = $request->asunto;
                $data['cuerpo'] = $request->cuerpo;

                if (Auth::user()->config != null) {
                    $mail = Auth::user()->config->config;
                } else {
                    $mail = 'smtp';
                }

                $send = Mail::mailer($mail)->to($data['para'])->send(new EnviarCuponConfirmacion($data));
                // $send           = Mail::mailer(Auth::user()->config->config)->to($data['para'])->send(new EnviarCuponConfirmacion($data));
                $res['success'] = true;
            }

        } catch (\Exception $e) {
            $this->sms->send_sms($e->getMessage());
            Log::critical($e->getMessage());
            $res['errors'] = $e->getMessage();
        }

        return response()->json($res);
    }

    public function enviarPago(Request $request)
    {

        // dd(Auth::user()->config);
        $res['success'] = false;
        try {
            $cupon = $this->construir_cupon_pago($request->id);
            if ($res) {
                $data['name']   = $cupon['name'];
                $data['file']   = $cupon['file'];
                $data['de']     = $request->de_p;
                $data['para']   = $request->para_p;
                $data['asunto'] = $request->asunto_p;
                $data['cuerpo'] = $request->cuerpo_p;

                if (Auth::user()->config != null) {
                    $mail = Auth::user()->config->config;
                } else {
                    $mail = 'smtp';
                }

                $send = Mail::mailer($mail)->to($data['para'])->send(new EnviarCuponPago($data));
                // $send           = Mail::to($data['para'])->send(new EnviarCuponPago($data));
                $res['success'] = true;
            }

        } catch (\Exception $e) {
            $this->sms->send_sms($e->getMessage());
            Log::critical($e->getMessage());
            $res['errors'] = $e->getMessage();
        }

        return response()->json($res);
    }

    /**
     * Autor: ISW. Diego Sanchez
     * Creado: 2023-03-03
     * Creacion de cupon de confirmacion reservacion
     * @param  [int] $id
     * @return [array] Retorna nombre y ruta del archivo para enviar por mail
     */
    public function construir_cupon_confirmacion($id)
    {
        $reservacion = Reservacion::findOrFail($id);

        if (file_exists(public_path() . '/files/reservaciones/confirmacion/' . 'CuponConfirmacion' . $reservacion->id . '.pdf')) {
            unlink(public_path() . '/files/reservaciones/confirmacion/' . 'CuponConfirmacion' . $reservacion->id . '.pdf');
        }

        $date_inicio = Carbon::create($reservacion->fecha_de_ingreso);
        $date_fin    = Carbon::create($reservacion->fecha_de_salida);

        if (file_exists(public_path() . '/files/reservaciones/confirmacion/' . 'CuponConfirmacion' . $reservacion->id . '.pdf')) {
            $res['name'] = 'CuponConfirmacion' . $reservacion->id . '.pdf';
            $res['file'] = public_path() . '/files/reservaciones/confirmacion/' . $res['name'];
            return $res;
        } else {
            //pax
            $data['pax']    = "";
            $adultos        = 0;
            $menores        = 0;
            $juniors        = 0;
            $edades         = array();
            $edades_juniors = array();

            foreach ($reservacion->r_habitaciones as $key => $habitacion) {
                $adultos = $adultos + $habitacion['adultos'];
                $menores = $menores + $habitacion['menores'];
                $juniors = $juniors + $habitacion['juniors'];

                for ($i = 1; $i <= $habitacion['menores']; $i++) {
                    $edades[] = $habitacion['edad_menor_' . $i];
                }

                for ($i = 1; $i <= $habitacion['juniors']; $i++) {
                    $edades_juniors[] = $habitacion['edad_junior_' . $i];
                }

            }

            if ($adultos > 0) {
                $data['pax'] .= $adultos . ' Adulto(s)';
            }

            if ($menores > 0) {
                $data['pax'] .= ' / ' . $menores . ' Menor(es) - ' . implode(",", $edades) . ' Años';
            }

            if ($juniors > 0) {
                $data['pax'] .= ' / ' . $juniors . ' Junior(s) - ' . implode(",", $edades_juniors) . ' Años';
            }

            $data['ano'] = $date_inicio->format('Y');
            $meses       = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fecha       = Carbon::parse($reservacion->fecha_limite_de_pago);
            /**
             * Fechas del cupon
             */
            $data['mes']        = $meses[($date_inicio->format('n')) - 1];
            $data['entrada']    = $date_inicio->format('d');
            $data['salida']     = $date_fin->format('d');
            $data['mes_salida'] = $meses[($date_fin->format('n')) - 1];

            $path = public_path() . '/files/reservaciones/confirmacion/';

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('admin.reservaciones.cupon_confirmacion', compact('reservacion', 'data'));
            $name = 'CuponConfirmacion' . $reservacion->id . '.pdf';
            $file = $path . $name;
            $pdf->save($file);

            $res['file'] = $file;
            $res['name'] = $name;

            return $res;
        }
    }

    /**
     * Autor: ISW. Diego Sanchez
     * Creado: 2023-03-06
     * Creacion de cupon de pago reservacion
     * @param  [int] $id
     * @return [array] Retorna nombre y ruta del archivo para enviar por mail
     */
    public function construir_cupon_pago($id)
    {
        $reservacion = Reservacion::findOrFail($id);
        $date_inicio = Carbon::create($reservacion->fecha_de_ingreso);
        $date_fin    = Carbon::create($reservacion->fecha_de_salida);

        if (file_exists(public_path() . '/files/reservaciones/pagos/' . 'CuponPago' . $reservacion->id . '.pdf')) {
            unlink(public_path() . '/files/reservaciones/pagos/' . 'CuponPago' . $reservacion->id . '.pdf');
        }

        if (file_exists(public_path() . '/files/reservaciones/pagos/' . 'CuponPago' . $reservacion->id . '.pdf')) {
            $res['name'] = 'CuponPago' . $reservacion->id . '.pdf';
            $res['file'] = public_path() . '/files/reservaciones/pagos/' . $res['name'];
            return $res;
        } else {

            $meses        = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $fecha        = Carbon::parse($reservacion->fecha_limite_de_pago);
            $mes          = $meses[($fecha->format('n')) - 1];
            $fecha_limite = $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
            /**
             * Fechas del cupon
             */
            $data['mes']        = $meses[($date_inicio->format('n')) - 1];
            $data['entrada']    = $date_inicio->format('d');
            $data['salida']     = $date_fin->format('d');
            $data['mes_salida'] = $meses[($date_fin->format('n')) - 1];

            $path = public_path() . '/files/reservaciones/pagos/';

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('admin.reservaciones.cupon_pago', compact('reservacion', 'data', 'fecha_limite'));
            $name = 'CuponPago' . $reservacion->id . '.pdf';
            $file = $path . $name;
            $pdf->save($file);

            $res['file'] = $file;
            $res['name'] = $name;

            return $res;
        }
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-10-03
     * Descripcion: Mostramos el formulario para poder seleccionar el ejecutivo al que se cambiara la estancia seleccionada
     * @param  [int] $reservacion_id
     * @return [json] Vista
     */
    public function cambiar_ejecutivo($reservacion_id)
    {
        $reservacion = Reservacion::findOrFail($reservacion_id);
        $padres      = Padre::whereHas('vendedor', function ($query) {
            return $query->where('role', 'reserver');
        })->get();

        $data['view'] = view('admin.users.elementos.cambiar_ejecutivo', compact('reservacion', 'padres'))->render();
        return response()->json($data);

    }

    public function update_ejecutivo(Request $request, $reservacion_id)
    {
        $data['success'] = false;

        $reservacion = Reservacion::findOrFail($reservacion_id);

        $reservacion->padre_id = $request->user_id;

        if ($reservacion->save()) {
            $data['success'] = true;
        }

        return response()->json($data);
    }

}
