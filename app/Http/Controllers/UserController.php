<?php

namespace App\Http\Controllers;

use App\AlertaMx;
use App\ConfigUser;
// use App\Helpers\Users;
use App\Contrato;
use App\Convenio;
use App\Incidencia;
use App\Mail\RegistroCliente;
use App\Mail\SendNewPassword;
use App\Padre;
use App\Salesgroup;
use App\Tarjeta;
use App\Traits\LogTrait;
use App\Traits\PassPacific;
use App\User;
use App\Reservacion;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Log;
use Mail;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    use PassPacific, LogTrait;

    private $user;

    public $max_contratos = 20;
    public $max_tarjetas  = 5;

    public function __construct()
    {
        ini_set('max_execution_time', 360000);
        $this->middleware('auth');
    }

    /**
     * Validacion de formulario para crear usuario
     * Autor: Diego Enrique Sanchez
     * Creado: 2021-08-09
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_form(Request $request, $method = 'POST', $user = null)
    {
        $validator = \Validator::make($request->all(), [
            'nombre'           => 'required | string | max:40',
            'apellidos'        => 'required | string | max:40',
            'username'         => ($method == 'POST') ? 'required | email  | unique:users' : 'required | email  | unique:users,username,' . $user,
            'password'         => ($method == 'POST') ? 'required | string | min:6' : '', //| confirmed
            'direccion'        => 'required | string | max:255',
            'telefono'         => 'required | numeric | digits:10',
            'telefono_casa'    => ($request->telefono_casa) ? 'numeric | digits:10' : '',
            'telefono_oficina' => ($request->telefono_oficina) ? 'numeric | digits:10' : '',
            'convenio_id'      => 'required',
            // 'colonia'          => (env('APP_PAIS_ID') == 1) ? 'required' : '',
            'colonia'          => ($request->colonia) ? 'required' : '',
            'cp'               => ($request->cp) ? 'required' : '',
            'como_se_entero'   => 'required',
            'role'             => (Auth::user()->role == 'admin') ? 'required' : '',
            'cumpleanos'       => ($request->cumpleanos) ? 'date_format:Y-m-d' : '',
        ]);
        return $validator;
    }

    /**
     * Validacion de formulario para crear usuario
     * Autor: Diego Enrique Sanchez
     * Creado: 2021-08-09
     * @param  Request $request
     * @param  Int  $id  validar datos del usuario existente
     * @return validacion
     */
    public function validar_perfil(Request $request, $method = 'POST', $user = null)
    {
        $validator = \Validator::make($request->all(), [
            'nombre'           => 'required | string | max:40',
            'apellidos'        => 'required | string | max:40',
            'username'         => 'required | email  | unique:users,username,' . $user,
            'password'         => ($request->password) ? 'required | string | min:6' : '', //| confirmed
            'direccion'        => 'required | string | max:255',
            'telefono'         => 'required | numeric | digits:10',
            'telefono_casa'    => ($request->telefono_casa) ? 'numeric | digits:10' : '',
            'telefono_oficina' => ($request->telefono_oficina) ? 'numeric | digits:10' : '',
            // 'colonia'          => (env('APP_PAIS_ID') == 1) ? 'required' : '',
            'colonia'          => ($request->colonia) ? 'required' : '',
            'cp'               => ($request->cp) ? 'required' : '',
            'cumpleanos'       => ($request->cumpleanos) ? 'date_format:Y-m-d' : '',
        ]);
        return $validator;
    }

    /**
     * Listado de registros
     * Autor:Diego Enrique Sanchez
     * Creado:
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index');
    }

    /**
     * Listado de registros
     * Autor:Diego Enrique Sanchez
     * Creado:
     * @return \Illuminate\Http\Response
     */
    public function clientes_ejecutivo($user_id = null)
    {
        return view('admin.users.listar_usuarios_ejecutivo', compact('user_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $convenios = Convenio::select('id', 'empresa_nombre')
        //     ->where('paise_id', 1)->get();

        $all_convenios = Convenio::where('paise_id', config('app.pais_id'))->pluck('id', 'empresa_nombre');
        $equipos       = Salesgroup::all();
        return view('admin.users.create', compact('equipos', 'all_convenios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data['success'] = false;

        $padre_id = Padre::where('user_id', Auth::user()->id)->first()->id;

        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $pass  = $this->get_password($request->password);
        $fecha = Carbon::now();

        $user              = new User;
        $user->convenio_id = $request->convenio_id;
        $user->padre_id    = ($padre_id) ? $padre_id : env('PADRE_ID');
        $user->username    = ltrim(rtrim($request->username));

        $user->password = ($pass != null) ? $pass['password'] : bcrypt($request->password);
        // $user->user_hash = $pass['user_hash'];
        $user->clave     = base64_encode($request->password);
        $user->pass_hash = bcrypt($request->password);

        $user->role               = ($request->role) ? $request->role : 'client';
        $user->manager            = 0;
        $user->created            = $fecha;
        $user->modified           = $fecha;
        $user->nombre             = ltrim(rtrim($request->nombre));
        $user->apellidos          = ltrim(rtrim($request->apellidos));
        $user->direccion          = $request->direccion;
        $user->direccion2         = $request->direccion2;
        $user->ciudad             = (isset($request->delegacion)) ? $request->delegacion : $request->ciudad;
        $user->pais               = (($request->pais) ? $request->pais : (env('APP_PAIS_ID') == 1)) ? 'México' : 'United States';
        $user->telefono           = $request->telefono;
        $user->provincia          = $request->estado;
        $user->codigo_postal      = $request->cp;
        $user->cp_id              = $request->colonia;
        $user->cumpleanos         = $request->cumpleanos;
        $user->confirmado         = ($request->activiar_usuario) ? 1 : 0;
        $user->permitir_login     = ($request->activiar_usuario) ? 1 : 0;
        $user->numero_de_empleado = $request->no_empleado;
        $user->RFC                = $request->rfc;
        $user->entrada_1          = '08:30:00';
        $user->entrada_2          = '15:00:00';
        $user->salida_1           = '15:00:00';
        $user->salida_2           = '18:30:00';
        $user->lu                 = 1;
        $user->ma                 = 1;
        $user->mi                 = 1;
        $user->ju                 = 1;
        $user->vi                 = 1;
        $user->sa                 = 1;
        $user->do                 = 1;

        $user->como_se_entero    = $request->como_se_entero;
        $user->alerta_enviada    = 0;
        $user->vetarifah         = 0;
        $user->estancia_paise_id = 0;

        $user->concurso_dwn         = 0;
        $user->supervisor_convenios = 0;

        $user->semestre_grado     = 0;
        $user->tipo_universitario = 0;
        $user->consulta_ventas    = 0;
        $user->autorizo           = 0;
        $user->alerta_enviada     = 0;
        $user->redes_sociales     = 0;

        if ($request->salesgroup_id) {
            $user->salesgroup_id = $request->salesgroup_id;
        }

        if ($user->save()) {
            if (isset($request->enviar_contrasena)) {
                Mail::to($user->username)->send(new RegistroCliente($user));
            }

            if ($user->role != 'client') {
                if ($user->admin_padre == null) {
                    Padre::create([
                        'user_id'              => $user->id,
                        'title'                => $user->username,
                        'correo_institucional' => $user->username,
                        'nombre'               => $user->fullName,
                    ]);
                }

            }

            $data['success'] = true;
            $data['url']     = route('users.show', $user->id);
        }

        return response()->json($data);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user       = User::findOrFail($id);
        $ejecutivos = User::whereRole('reserver')->get();
        $this->authorize('view', $user);
        // Log::debug("info del usuario ::".print_r($user,1));

        // Datos para validar los registros de tarjetas y contratos
        $cont                   = array();
        $cont['user_contratos'] = count($user->contratos);
        $cont['user_tarjetas']  = count($user->tarjetas);
        $cont['max_contratos']  = $this->max_contratos;
        $cont['max_tarjetas']   = $this->max_tarjetas;
        $cont['role']           = Auth::user()->role;
        
        if (!$user) {
            abort(404);
        }

        $historial = strstr($user->historico, '</ul>', true);
        $contratos = Contrato::with('pagos_contrato')->where('user_id', $id)->paginate(10);

        foreach ($contratos as $key => $contrato) {
            $pagos = $contrato->pagos_contrato;

            $pagos_total       = 0;
            $pagos_concretados = 0;
            $pagos_rechazados  = 0;
            $pagos_cancelados  = 0;
            $pagos_bonificados = 0.0;
            $pagos_extras      = 0.0;
            $pagos_pendientes  = 0.0;
            $saldo_pagado      = 0.0;
            $saldo_rechazado   = 0.0;
            $saldo_bonificado  = 0.0;
            $saldo_extra       = 0.0;
            $saldo_pendiente   = 0.0;
            $saldo_cancelado   = 0.0;
            $saldo_total       = 0.0;

            foreach ($pagos as $pago) {
                $pagos_total++;
                $saldo_total += $pago->cantidad;
                switch ($pago->estatus) {
                    case 'Por Pagar':
                        $pagos_pendientes++;
                        $saldo_pendiente += $pago->cantidad;
                        break;
                    case 'Pagado':
                        $pagos_concretados++;
                        $saldo_pagado += $pago->cantidad;
                        break;
                    case 'Rechazado':
                        $pagos_rechazados++;
                        $saldo_rechazado += $pago->cantidad;
                        break;
                    case 'Cancelado':
                        $pagos_cancelados++;
                        $saldo_cancelado += $pago->cantidad;
                        break;
                }
            }
            $contratos[$key]['sumario'] = compact('pagos_total', 'pagos_concretados', 'pagos_rechazados', 'pagos_cancelados', 'pagos_bonificados', 'pagos_extras', 'pagos_pendientes', 'saldo_pagado', 'saldo_rechazado', 'saldo_bonificado', 'saldo_extra', 'saldo_pendiente', 'saldo_cancelado', 'saldo_total');
        }

        return view('admin.users.show', compact('user', 'contratos', 'historial', 'ejecutivos', 'cont'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function historial($id, $type = null)
    {
        $data['success'] = false;
        $user            = User::findOrFail($id);
        if ($user) {
            $data['success'] = true;

            if (isset($type)) {
                $data['historico'] = $user->logUser;
            } else {
                $data['historico'] = $user->historico;
            }
        }

        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user          = User::findOrFail($id);
        $all_convenios = Convenio::where('paise_id', config('app.pais_id'))->pluck('id', 'empresa_nombre');

        $equipos = Salesgroup::all();

        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user', 'all_convenios', 'equipos'));
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
        $data['success'] = false;

        $method   = $request->method();
        $user     = User::findOrFail($id);
        $temporal = $user->toArray();

        $validate = $this->validar_form($request, $method, $user->id);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $fecha = Carbon::now();

        $user->convenio_id = $request->convenio_id;
        $user->username    = $request->username;

        if ($request->password) {
            if (env('APP_ENV') == 'Production') {
                $pass           = $this->get_password($request->password);
                $user->password = $pass['password'];
            }
            $user->clave     = base64_encode($request->password);
            $user->pass_hash = bcrypt($request->password);
        }

        if ($request->role) {
            $user->role = ($request->role) ? $request->role : 'client';
        }

        $user->modified           = $fecha;
        $user->nombre             = $request->nombre;
        $user->apellidos          = $request->apellidos;
        $user->direccion          = $request->direccion;
        $user->direccion2         = $request->direccion2;
        $user->ciudad             = (isset($request->delegacion)) ? $request->delegacion : $request->ciudad;
        $user->pais               = (($request->pais) ? $request->pais : (env('APP_PAIS_ID') == 1)) ? 'México' : 'United States';
        $user->telefono           = $request->telefono;
        $user->telefono_casa      = $request->telefono_casa;
        $user->telefono_oficina   = $request->telefono_oficina;
        $user->provincia          = $request->estado;
        $user->codigo_postal      = $request->cp;
        $user->cp_id              = $request->colonia;
        $user->como_se_entero     = $request->como_se_entero;
        $user->numero_de_empleado = $request->no_empleado;
        $user->rfc                = $request->rfc;
        $user->cumpleanos         = $request->cumpleanos;
        if ($request->salesgroup_id) {
            $user->salesgroup_id = $request->salesgroup_id;
        }

        if ($user->save()) {

            /**
             * Creacion o edicion del historial de cambios al registro
             * Cambiar o programar un observer para evitar la llamada al metodo y hacerlo automaticamente al ejecutar el evento update del modelo
             */
            $this->create_log(Auth::user(), $user->getChanges(), $temporal, $user);

            if (isset($request->reenviar_contraseña)) {
                Mail::to($user->username)->send(new SendNewPassword($user));
            }

            if ($user->role != 'client') {
                try {
                    if ($user->admin_padre == null) {
                        Padre::create([
                            'user_id'              => $user->id,
                            'title'                => $user->username,
                            'correo_institucional' => $user->username,
                            'nombre'               => $user->fullName,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::notice('No se pudo generar el registro de "padre" del usuario: ' . $user->id);
                }

            }

            $data['success'] = true;
            $data['url']     = route('users.show', $user->id);
        }

        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['success'] = false;
        $user            = User::destroy($id);
        if ($user == true) {
            $data['success'] = true;
            $data['url']     = route('users.show_clientes');
            $data['message'] = '¡Usuario eliminado exitasamente!';
        } else {
            $data['message'] = '¡No se pudo eliminar este usuario!';
        }

        return response()->json($data);
    }

    /**
     * Listado de tarjetas por cliente
     * Autor: Diego Enrique Sanchez
     * Creado: 2021-08-28
     * @param  [int] $id
     * @return Response $result definido para pintar el datatable
     */
    public function get_tarjetas($id)
    {

        $tarjetas = Tarjeta::where('user_id', $id)->orderBy('created', 'ASC')->get();

        $data = array();
        $i    = 1;
        $btn  = '';

        foreach ($tarjetas as $tarjeta) {
            $contratos       = Contrato::where('tarjeta_id', $tarjeta->id)->get();
            $reservaciones   = Reservacion::where('tarjeta_id', $tarjeta->id)->get();
            $con             = '';
            $res             = '';
            $message         = '';
            $flag = false;
    
            if (count($contratos) >= 1) {
                $flag = true;
                foreach ($contratos as $c) {
                    $con .= $c->id . ',';
                }
                $message .= "La tarjeta esta registrada a los folios: $con <br><br>";
            }
    
            if (count($reservaciones) >= 1) {
                $flag = true;
                foreach ($reservaciones as $r) {
                    $res .= $r->id . ',';
                }
                $message .= "La tarjeta esta registrada a la(s) reservación: $res";
            }

            $btn = '';
            if (Auth::user()->can('update', $tarjeta)) {
                $btn .= '<button class="btn btn-success btn-xs mr-2" data-url="' . route('cards.edit', $tarjeta->id) . '"  value="' . $tarjeta->id . '" id="btnEditarTarjeta" type="button"><i class="fas fa-edit"></i></button>';
            }
            if (Auth::user()->can('delete', $tarjeta)) {
                $btn .= '<button class="btn btn-danger btn-xs" data-flag="'.$flag.'" data-message="'.$message.'" value="' . $tarjeta->id . '" data-url_tarjeta="' . route('cards.destroy', $tarjeta->id) . '" data-tarjeta="' . $tarjeta->numeroTarjeta . '" id="btnEliminarTarjeta" type="button"><i class="fas fa-trash"></i></button>';
            }

            if (Auth::user()->can('delete', $tarjeta)) {
                $btnInfo = '<button class="btn btn-dark btn-xs btnLogTarjeta" data-tarjeta_id="' . $tarjeta->id . '" id="btnLogTarjeta" type="button"><i class="fa fa-exclamation-circle"></i></button>';
            } else {
                $btnInfo = '';
            }

            $data[] = array(
                "0" => $btnInfo,
                "1" => '<span class="text-muted">' . $tarjeta->name . '</span><h6>' . $tarjeta->numeroTarjeta . '</h6>',
                // "2" => '<span class="text-muted">' . $tarjeta->banco . '</span><h6>' . $tarjeta->mes . '/' . $tarjeta->ano . '</h6>',
                "2" => '<span class="text-muted">' . $tarjeta->banco . '</span><h6>' . $tarjeta->vence . '</h6>' . '<h6>' . $tarjeta->verCvv . '</h6>',
                "3" => '<h6>' . $tarjeta->estatus . '</h6>',
                "4" => '<span class="text-muted">' . ($tarjeta->r_banco) ? $tarjeta->r_banco->title : 'N/A' . '</span><h6>' . $tarjeta->tipo . '</h6>',
                "5" => $btn,
                "6" => $tarjeta->created . '<br/>' . $tarjeta->modified,
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
     * Listado de contratos a cliente especifico
     * Autor: Diego Enrique Sanchez
     * Creato: 2021-08-28
     * @param  [int] $id
     * @return Response $result definido para pintar el datatable
     */
    public function get_contratos($id)
    {
        $contratos = Contrato::with('pagos_contrato')->where('user_id', $id)->get();
        $fecha_hoy = Carbon::now();

        foreach ($contratos as $key => $contrato) {

            $pagos = $contrato->pagos_contrato;

            $pagos_total       = 0;
            $pagos_concretados = 0;
            $pagos_rechazados  = 0;
            $pagos_cancelados  = 0;
            $pagos_bonificados = 0.0;
            $pagos_extras      = 0.0;
            $pagos_pendientes  = 0.0;

            $saldo_pagado     = 0.0;
            $saldo_rechazado  = 0.0;
            $saldo_bonificado = 0.0;
            $saldo_extra      = 0.0;
            $saldo_pendiente  = 0.0;
            $saldo_cancelado  = 0.0;
            $saldo_total      = 0.0;

            foreach ($pagos as $pago) {
                $pagos_total++;
                if ($pago->concepto != 'Enganche') {
                    $saldo_total += $pago->cantidad;
                }
                switch ($pago->estatus) {
                    case 'Por Pagar':
                        $pagos_pendientes++;
                        if ($pago->concepto != 'Enganche') {
                            $saldo_pendiente += $pago->cantidad;
                        }
                        break;
                    case 'Pagado':
                        if ($pago->concepto != 'Enganche') {
                            $pagos_concretados++;
                            $saldo_pagado += $pago->cantidad;
                        }
                        break;
                    case 'Rechazado':
                        if ($pago->concepto != 'Enganche') {
                            $pagos_rechazados++;
                            $saldo_rechazado += $pago->cantidad;
                        }
                        break;
                    case 'Cancelado':
                        $pagos_cancelados++;
                        $saldo_cancelado += $pago->cantidad;
                        break;
                }
            }

            $saldo_pendiente = $saldo_pendiente + $saldo_rechazado;

            $contratos[$key]['sumario'] = compact('pagos_total', 'pagos_concretados', 'pagos_rechazados', 'pagos_cancelados', 'pagos_bonificados', 'pagos_extras', 'pagos_pendientes', 'saldo_pagado', 'saldo_rechazado', 'saldo_bonificado', 'saldo_extra', 'saldo_pendiente', 'saldo_cancelado', 'saldo_total');
        }

        $data      = array();
        $btn       = '';
        $btnPagos  = '';
        $btnInfo   = '';
        $folio     = '';

        foreach ($contratos as $contrato) {
            $date_pay = $contrato->fecha_primer_descuento();

            // $vigencia = $this->validar_vigencia($fecha_hoy, $date_pay, $contrato);

            if ($date_pay != false) {
                $activacion = Carbon::create($date_pay);
                if ($activacion->diffInYears($fecha_hoy) >= 1) {
                    $vencimiento_text = '<br> Vencido';
                    $vencimiento      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: <strong>" . $activacion->addYear()->format('Y-m-d') . "</strong>";
                } else {
                    $vencimiento_text = '';
                    $vencimiento      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: <b> Contrato vigente</b>";
                }
            } else {
                $vencimiento      = "<b>Este contrato no cuenta con segmentos a cobro programados... </b>";
                $vencimiento_text = '';
            }

            $btnInfo = '<button class="btn btn-dark btn-xs btnLogContrato" data-contrato_id="' . $contrato->id . '" id="btnLogContrato" type="button"><i class="fa fa-exclamation-circle"></i></button>';

            // Valida si existe imagen vinculada al contrato para mostrar el boton  de calidad
            if (count($contrato->imagenes) != 0) {
                $btnInfo .= '<br> <button class="btn btn-info btn-xs mt-1" data-toggle="tooltip" title="Este folio cuenta con respaldo de calidad"><i class="fas fa-check"></i></button>';
            }

            //estructura de la columna folio
            $ven = ($contrato->padre) ? $contrato->padre->title : 'Sin vendedor';

            if (Auth::user()->role == 'admin') {
                $folio = "<strong>$contrato->id <br/><span style='font-size:12px'>$contrato->sys_key</span><br/><small class='text-info' style='font-size: 10px'><strong data-id='$contrato->padre_id' data-contrato_id='$contrato->id' id='btnCanbiarPadre'>" . __('messages.user.show.vendedor') . " : <br/>$ven</strong></small><strong>";
            } else {
                $folio = "<strong>$contrato->id <br/><span style='font-size:12px'>$contrato->sys_key</span><br/><small class='text-info' style='font-size: 10px'><strong data-id='$contrato->padre_id' data-contrato_id='$contrato->id' id=''>" . __('messages.user.show.vendedor') . " : <br/>$ven</strong></small><strong>";
            }

            $saldo_favor = '';

            if (($contrato->precio_de_compra - $contrato->sumario['saldo_pagado']) < 0) {
                $saldo_favor = '<small class="text-info">($' . number_format(abs($contrato->precio_de_compra - $contrato->sumario['saldo_pagado']), 2, '.', '') . ' ' . $contrato->divisa . ')</small>';
            } else {
                $saldo_favor = '<small >$' . number_format(abs($contrato->precio_de_compra - $contrato->sumario['saldo_pagado']), 2, '.', '') . ' ' . $contrato->divisa . '</small>';
            }

            $data[] = array(
                "0" => $btnInfo,
                "1" => $folio,
                "2" => '<label>' . $contrato->paquete . '</label><br><small  style="font-size: 12px">' . $contrato->metodo_de_pago_show() . '</small>',
                "3" => '<button type="button" id="btnInfoContrato" data-title="' . $vencimiento . '" class="btn btn-xs text-white text-capitalize" style="background-color:  ' . $contrato->color_estatus() . ';  font-size: 12px">' . $contrato->estatus . $vencimiento_text . '</button>',
                "4" => '$' . number_format($contrato->precio_de_compra, 2) . ' ' . $contrato->divisa . '<br>' . $saldo_favor,
                "5" => '$' . number_format($contrato->sumario['saldo_pagado'], 2) . ' ' . $contrato->divisa . '<br>' . '$' . ($contrato->sumario['saldo_pendiente'] < 0) ? '(' . number_format($contrato->sumario['saldo_pendiente'], 2) . ')' : number_format($contrato->sumario['saldo_pendiente'], 2) . ' ' . $contrato->divisa,
                "6" => $this->botones_pagos($btnPagos, $contrato, 2),
                "7" => $this->botones_accion($btn, $contrato),
                "8" => isset($contrato->tarjeta) ? true : false
            );
            $btn       = '';
            $btnPagos  = '';
            $btnInfo   = '';
            $folio     = '';
        }

        // dd($data);
        //DEVUELVE LOS DATOS EN UN JSON
        $results = array(
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"               => $data,
        );
        return response()->json($results);
    }

    /*
    public function get_contratos($id)
    {
        $contratos = (new Contrato)->sp_clientes_getContratos($id);
        $fecha_hoy = Carbon::now();
        
        $data      = array();
        $btn       = '';
        $btnPagos  = '';
        $btnInfo   = '';
        $folio     = '';

        foreach ($contratos['data'] as $contrato) {
            
            $date_pay = $contrato['fecha_primer_segmento'];

            if (!empty($date_pay)) {
                $activacion = Carbon::create($date_pay);
                if ($activacion->diffInYears($fecha_hoy) >= 1) {
                    $vencimiento_text = '<br> Vencido';
                    $vencimiento      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: <strong>" . $activacion->addYear()->format('Y-m-d') . "</strong>";
                } else {
                    $vencimiento_text = '';
                    $vencimiento      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: <b> Contrato vigente</b>";
                }
            } else {
                $vencimiento      = "<b>Este contrato no cuenta con segmentos a cobro programados... </b>";
                $vencimiento_text = '';
            }

            $btnInfo = '<button class="btn btn-dark btn-xs btnLogContrato" data-contrato_id="' . $contrato['id_folio'] . '" id="btnLogContrato" type="button"><i class="fa fa-exclamation-circle"></i></button>';

            // Valida si existe imagen vinculada al contrato para mostrar el boton  de calidad
            if ($contrato['estatus_calidad'] == '1') {
                $btnInfo .= '<br> <button class="btn btn-info btn-xs mt-1" data-toggle="tooltip" title="Este folio cuenta con respaldo de calidad"><i class="fas fa-check"></i></button>';
            }

            //estructura de la columna folio
            $ven = $contrato['correo_vendedor'];

            if (Auth::user()->role == 'admin') {
                $folio = "<strong>{$contrato['id_folio']} <br/><span style='font-size:12px'>{$contrato['sys_key']}</span><br/><small class='text-info' style='font-size: 10px'><strong data-id={$contrato['padre_id']} data-contrato_id={$contrato['id_folio']} id='btnCanbiarPadre'>" . __('messages.user.show.vendedor') . " : <br/>$ven</strong></small><strong>";
            } else {
                $folio = "<strong>{$contrato['id_folio']}<br/><span style='font-size:12px'>{$contrato['sys_key']}</span><br/><small class='text-info' style='font-size: 10px'><strong data-id={$contrato['padre_id']} data-contrato_id={$contrato['id_folio']} id=''>" . __('messages.user.show.vendedor') . " : <br/>$ven</strong></small><strong>";
            }

            $saldo_favor = '';

            if ($contrato['cantidad_pendiente'] < 0) {
                $saldo_favor = '<small class="text-info"> $' . number_format(abs($contrato['cantidad_pendiente']), 2, '.', '') . $contrato['divisa']. ' </small>';
            } else {
                $saldo_favor = '<small >$' . number_format(abs($contrato['cantidad_pendiente']), 2, '.', ''). $contrato['divisa'].' </small>';
            }

            $data[] = array(
                "0" => $btnInfo,
                "1" => $folio,
                "2" => '<label>' . $contrato['nombre_paquete'] . '</label><br><small  style="font-size: 12px">'.$contrato['tipo_descuento'].'</small>',
                "3" => '<button type="button" id="btnInfoContrato" data-title="' . $vencimiento . '" class="btn btn-xs text-white text-capitalize" style="background-color:'.$contrato['color_estatus'].';font-size: 12px">' . $contrato['estatus'] . $vencimiento_text . '</button>',
                "4" => '$' . number_format($contrato['precio_de_compra'], 2) . ' ' . $contrato['divisa'] . '<br>' . $saldo_favor,
                "5" => '$' . number_format($contrato['pagos_concretados'], 2) . ' ' . $contrato['divisa'] . '<br>' . '$' . ($contrato['cantidad_pendiente'] < 0) ? '(' . number_format($contrato['cantidad_pendiente'], 2) . ')' : number_format($contrato['cantidad_pendiente'], 2) . ' ' . $contrato['divisa'],
                "6" => $this->botones_pagos($btnPagos, $contrato, 2),
                "7" => $this->botones_accion($btn, $contrato),
                //"8" => isset($contrato->tarjeta) ? true : false
                "8" => ''
            );
            $btn       = '';
            $btnPagos  = '';
            $btnInfo   = '';
            $folio     = '';
        }

        //DEVUELVE LOS DATOS EN UN JSON
        $results = array(
            "sEcho"                => 1,
            "iTotalRecords"        => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"               => $data,
        );
        return response()->json($results);
    }*/
    

    public function validar_vigencia($fecha_hoy, $date_pay, $contrato)
    {
        $data['vencimiento']      = "";
        $data['vencimiento_text'] = '';
        if ($date_pay != false) {
            $activacion = Carbon::create($date_pay);
            if ($activacion->diffInYears($fecha_hoy) >= 1) {
                $data['vencimiento_text'] = '<br> Vencido';
                $data['vencimiento']      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: <strong>" . $activacion->addYear()->format('Y-m-d') . "</strong>";
            } else {
                $data['vencimiento_text'] = '';
                $data['vencimiento']      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: <b> Contrato vigente</b>";
            }

            // $num_pagos = count($contrato->cuotas_contrato);
            // //Pagos con vigencia de año y medio
            // if ($num_pagos >= 35 && $num_pagos <= 38 || $num_pagos >= 71 && $num_pagos <= 74 || $num_pagos >= 17 && $num_pagos <= 19 ) {

            //     if ($activacion->diffInMonths($fecha_hoy) > 18) {
            //         $data['vencimiento_text'] = '<br> Vencido';
            //         $data['vencimiento']      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: <strong>" . $activacion->addMonth(18)->format('Y-m-d') . "</strong>";
            //     } else {
            //         $data['vencimiento_text'] = '';
            //         $data['vencimiento']      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: ".$activacion->addMonth(18)->format('Y-m-d')."<br><b> Contrato vigente</b>";
            //     }
            // }else if ($num_pagos >= 23 && $num_pagos <= 25 || $num_pagos >= 46 && $num_pagos <= 49 || $num_pagos >= 11 && $num_pagos <= 13 ) {
            //     if ($activacion->diffInMonths($fecha_hoy) > 12) {
            //         $data['vencimiento_text'] = '<br> Vencido';
            //         $data['vencimiento']      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: <strong>" . $activacion->addYear(1)->format('Y-m-d') . "</strong>";
            //     } else {
            //         $data['vencimiento_text'] = '';
            //         $data['vencimiento']      = "Activación: " . $activacion->format('Y-m-d') . "<br> Vencimiento: ".$activacion->addMonth(12)->format('Y-m-d')."<br><b> Contrato vigente</b>";
            //     }
            // }
        } else {
            $data['vencimiento']      = "<b>Este contrato no cuenta con segmentos a cobro programados... </b>";
            $data['vencimiento_text'] = '';
        }

        return $data;

    }
    
    public function botones_pagos($btnPagos, $contrato, $flag = 1)
    {
        if ($flag == 1) {

            $btnPagos .= '<button class="btn btn-primary btn-xs m-1 btnMostratPagos" data-id="all" id="btnTotal" type="button" value="' . $contrato->id . '">' . __('messages.user.show.total') . ' : ' . $contrato->sumario['pagos_total'] . ' <br/>' . $contrato->divisa . '' . number_format($contrato->sumario['saldo_total'], 2) . '</button>';
            $btnPagos .= '<button class="btn btn-info btn-xs m-1 btnMostratPagos" data-id="concretados" id="btnConcretados" type="button" value="' . $contrato->id . '">' . __('messages.user.show.concretados') . ':' . $contrato->sumario['pagos_concretados'] . '<br/>' . $contrato->divisa . ' ' . number_format($contrato->sumario['saldo_pagado'], 2) . '</button>';

            $btnPagos .= '<button class="btn btn-warning btn-xs m-1 btnMostratPagos" data-id="pendientes" id="btnPendientes" type="button" value="' . $contrato->id . '">' . __('messages.user.show.pendientes') . ': ' . $contrato->sumario['pagos_pendientes'] . '<br/>' . $contrato->divisa . ' ' . number_format($contrato->precio_de_compra - $contrato->sumario['saldo_pagado'], 2) . '</button>';

            $btnPagos .= '<button class="btn btn-danger btn-xs m-1 btnMostratPagos" data-id="rechazados" id="btnRechazados" type="button" value="' . $contrato->id . '">' . __('messages.user.show.rechazados') . ': ' . $contrato->sumario['pagos_rechazados'] . '<br/>' . $contrato->divisa . ' ' . number_format($contrato->sumario['saldo_rechazado'], 2) . '</button>';

        } else {
            // $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="all" id="btnTotal" type="button" value="' . $contrato->id . '">' . __('messages.user.show.total') . ' : ' . $contrato->sumario['pagos_total'] . ' <br/>' . $contrato->divisa . '' . number_format($contrato->sumario['saldo_total'], 2) . '</button>';
            $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="all" id="btnTotal" type="button" value="' . $contrato->id . '">' . __('messages.user.show.total') . ' : ' . $contrato->sumario['pagos_total'] . ' <br/>' . $contrato->divisa . '' . number_format($contrato->precio_de_compra, 2) . '</button>';

            $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="concretados" id="btnConcretados" type="button" value="' . $contrato->id . '">' . __('messages.user.show.concretados') . ':' . $contrato->sumario['pagos_concretados'] . '<br/>' . $contrato->divisa . ' ' . number_format($contrato->sumario['saldo_pagado'], 2) . '</button>';

            $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="pendientes" id="btnPendientes" type="button" value="' . $contrato->id . '">' . __('messages.user.show.pendientes') . ': ' . $contrato->sumario['pagos_pendientes'] . '<br/>' . $contrato->divisa . ' ' . number_format($contrato->precio_de_compra - $contrato->sumario['saldo_pagado'], 2) . '</button>';

            $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="rechazados" id="btnRechazados" type="button" value="' . $contrato->id . '">' . __('messages.user.show.rechazados') . ': ' . $contrato->sumario['pagos_rechazados'] . '<br/>' . $contrato->divisa . ' ' . number_format($contrato->sumario['saldo_rechazado'], 2) . '</button>';

            $btnPagos = '<div class="btn-group">
                          <button type="button" class="btn btn-success btn-xs btnMostratPagos" data-id="all" id="btnTotal" value="' . $contrato->id . '">' . __('messages.user.show.total') . ' : ' . $contrato->sumario['pagos_total'] . ' <br/>' . $contrato->divisa . ' ' . number_format($contrato->sumario['saldo_pagado'], 2) . '</button>
                          <button type="button" class="btn btn-success btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <div class="dropdown-menu">
                            ' . $btnPagos . '
                          </div>
                        </div>';
        }
        return $btnPagos;
    }

    /*
    public function botones_pagos($btnPagos, $contrato, $flag = 1)
    {
        if ($flag == 1) {

            $btnPagos .= '<button class="btn btn-primary btn-xs m-1 btnMostratPagos" data-id="all" id="btnTotal" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.total') . ' : ' . $contrato['pagos_total'] . ' <br/>' . $contrato['divisa'] . '' . number_format($contrato['precio_de_compra'], 2) . '</button>';
            $btnPagos .= '<button class="btn btn-info btn-xs m-1 btnMostratPagos" data-id="concretados" id="btnConcretados" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.concretados') . ':' . $contrato['pagos_concretados'] . '<br/>' . $contrato['divisa'] . ' ' . number_format($contrato['saldo_pagado'], 2) . '</button>';

            $btnPagos .= '<button class="btn btn-warning btn-xs m-1 btnMostratPagos" data-id="pendientes" id="btnPendientes" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.pendientes') . ': ' . $contrato['pagos_pendientes'] . '<br/>' . $contrato['divisa'] . ' ' . number_format( $contrato['cantidad_pendiente'], 2) . '</button>';

            $btnPagos .= '<button class="btn btn-danger btn-xs m-1 btnMostratPagos" data-id="rechazados" id="btnRechazados" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.rechazados') . ': ' . $contrato['pagos_rechazados'] . '<br/>' . $contrato['divisa'] . ' ' . number_format($contrato['saldo_rechazado'], 2) . '</button>';

        } else {
            // $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="all" id="btnTotal" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.total') . ' : ' . $contrato['pagos_total'] . ' <br/>' . $contrato['divisa'] . '' . number_format($contrato['saldo_total'], 2) . '</button>';
            $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="all" id="btnTotal" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.total') . ' : ' . $contrato['pagos_total'] . ' <br/>' . $contrato['divisa'] . '' . number_format($contrato['precio_de_compra'], 2) . '</button>';

            $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="concretados" id="btnConcretados" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.concretados') . ':' . $contrato['pagos_concretados'] . '<br/>' . $contrato['divisa'] . ' ' . number_format($contrato['saldo_pagado'], 2) . '</button>';

            $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="pendientes" id="btnPendientes" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.pendientes') . ': ' . $contrato['pagos_pendientes'] . '<br/>' . $contrato['divisa'] . ' ' . number_format($contrato['cantidad_pendiente'], 2) . '</button>';

            $btnPagos .= '<button class="dropdown-item btnMostratPagos" data-id="rechazados" id="btnRechazados" type="button" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.rechazados') . ': ' . $contrato['pagos_rechazados'] . '<br/>' . $contrato['divisa'] . ' ' . number_format($contrato['saldo_rechazado'], 2) . '</button>';

            $btnPagos = '<div class="btn-group">
                          <button type="button" class="btn btn-success btn-xs btnMostratPagos" data-id="all" id="btnTotal" value="' . $contrato['id_folio'] . '">' . __('messages.user.show.total') . ' : ' . $contrato['pagos_total'] . ' <br/>' . $contrato['divisa'] . ' ' . number_format($contrato['saldo_pagado'], 2) . '</button>
                          <button type="button" class="btn btn-success btn-xs dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="sr-only">Toggle Dropdown</span>
                          </button>
                          <div class="dropdown-menu">
                            ' . $btnPagos . '
                          </div>
                        </div>';
        }
        return $btnPagos;
    }*/
    
    public function botones_accion($btn, $contrato, $flag = 1)
    {

        $btn .= (Auth::user()->can('reenviar_contrato', $contrato)) ? '<a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-pagos_concretados="' . $contrato->pagos_concretados() . '" data-placement="top" data-toggle="tooltip" data-user_name="' . $contrato->cliente->fullName . '" data-username="' . $contrato->cliente->username . '" id="btnReenviarContrato" title="Reenviar contrato"  value="' . $contrato->id . '"><i class="fas fa-paper-plane"></i> Reenviar contrato</a>' : '';

        $btn .= (Auth::user()->can('mostrar_contrato', $contrato)) ? '<a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-pagos_concretados="' . $contrato->pagos_concretados() . '" data-placement="top" data-toggle="tooltip" id="btnVerContrato" title="Ver contrato"  value="' . $contrato->id . '"> <i class="fas fa-file-pdf"></i> Ver contrato</a>' : '';

        $btn .= (Auth::user()->can('convertir_estancia', $contrato)) ? ' <a class="dropdown-item btnConvertir" data-estancia_id="" data-estatus="' . $contrato->estatus . '" data-pagos_concretados="' . $contrato->pagos_concretados() . '" data-placement="top" data-toggle="tooltip" id="btnConvertir" title="Convertir estancia"  value="' . $contrato->id . '"><i class="fas fa-cog"></i> Convertir estancia</a>' : '';

        $btn .= (Auth::user()->can('editar_contrato', $contrato)) ? ' <a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-pagos_concretados="' . $contrato->pagos_concretados() . '" data-placement="top" data-toggle="tooltip" id="btnEditarContrato" title="Editar contrato"  value="' . $contrato->id . '"><i class="fas fa-edit"></i> Editar</a>' : '';

        $btn .= (Auth::user()->can('metodo_de_pago', $contrato)) ? '<a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-pagos_concretados="' . $contrato->pagos_concretados() . '" data-placement="top" data-route="' . route('contrato.show_metodo_pago', $contrato->id) . '" data-toggle="tooltip" id="btnMetodoPago" title="Cambiar metodo de cobro"  value="' . $contrato->id . '"><i class="fas fa-money-bill-wave-alt"></i> Metodo de pago</a>' : '';

        $btn .= (Auth::user()->can('recalcular_contrato', $contrato)) ? '<a class="dropdown-item btnCalPagos" data-estatus="' . $contrato->estatus . '" data-pagos_concretados="' . $contrato->pagos_concretados() . '" data-placement="top" data-toggle="tooltip" href="#modalCalculador" id="btnCalPagos" title="Calcular pagos"  value="' . $contrato->id . '" data-contrato_id="' . $contrato->id . '"><i class="fas fa-calculator"></i> Recalcular pagos</a>' : '';

        $btn .= (Auth::user()->can('calidad', $contrato)) ? ' <a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-placement="top" data-toggle="tooltip" id="btnCalidad" data-url="' . route('contratos.calidad', $contrato->id) . '" title="Cargar calidad"  value="' . $contrato->id . '"><i class="fas fa-check"></i> Cargar calidad</a>' : '';

        $btn .= (count($contrato->imagenes) != 0 && Auth::user()->can('ver_calidad', $contrato)) ? ' <a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-placement="top" data-toggle="tooltip" id="btnVerCalidad" data-url="' . route('contratos.ver_calidad', $contrato->id) . '" title="Ver respaldos"  value="' . $contrato->id . '"><i class="fas  fa-paperclip"></i> Ver calidad</a>' : '';

        $btn .= (Auth::user()->can('agregar_pago', $contrato)) ? ' <a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-pagos_concretados="' . $contrato->pagos_concretados() . '" data-placement="top" data-toggle="tooltip" id="btnAddPago" title="Agregar pago"  value="' . $contrato->id . '"><i class="fas fa-plus"></i> Agregar pago</a>' : '';

        $btn .= (Auth::user()->can('autorizar_folio', $contrato)) ? ' <a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-pagos_concretados="' . $contrato->pagos_concretados() . '" data-placement="top" data-toggle="tooltip" id="btnAutorizar" title="Autorizar Folio"  value="' . $contrato->id . '"><i class="fas fa-key"></i> Autorizar</a>' : '';

        // Desvincular folio de reservacion

        $btn .= (count($contrato->reservaciones) != 0 && Auth::user()->can('agregar_pago', $contrato)) ? ' <a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-placement="top" data-toggle="tooltip" id="btnDesvincular" title="Desvincular contrato de reservacion"   data-contrato_id="' . $contrato->id . '" data-url="' . route('contratos.reservaciones_vinculadas', $contrato->id) . '"><i class="fas fa-chain-broken"></i> Desvincular folio</a>' : '';

        $btn .= (Auth::user()->can('delete', $contrato)) ? ' <a class="dropdown-item" data-estatus="' . $contrato->estatus . '" data-placement="top" data-toggle="tooltip" id="btnDeleteContrato" data-url="' . route('contratos.destroy', $contrato->id) . '" title="Eliminar contrato"  value="' . $contrato->id . '"><i class="fas fa-trash"></i> Eliminar</a>' : '';

        $btn = '<div class="btn-group">
              <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
              </button>
              <div class="dropdown-menu">
               ' . $btn . '
              </div>
            </div>';

        return $btn;
    }

    /*
    public function botones_accion($btn, $contrato, $flag = 1)
    {

        $btn .= (Auth::user()->can('reenviar_contrato')) ? '<a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-pagos_concretados="' . $contrato['pagos_concretados'] . '" data-placement="top" data-toggle="tooltip" data-user_name="' . $contrato['nombre_cliente'] . '" data-username="' . $contrato['correo_cliente'] . '" id="btnReenviarContrato" title="Reenviar contrato"  value="' . $contrato['id_folio'] . '"><i class="fas fa-paper-plane"></i> Reenviar contrato</a>' : '';

        $btn .= (Auth::user()->can('mostrar_contrato')) ? '<a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-pagos_concretados="' . $contrato['pagos_concretados'] . '" data-placement="top" data-toggle="tooltip" id="btnVerContrato" title="Ver contrato"  value="' . $contrato['id_folio'] . '"> <i class="fas fa-file-pdf"></i> Ver contrato</a>' : '';

        $btn .= (Auth::user()->can('convertir_estancia')) ? ' <a class="dropdown-item btnConvertir" data-estancia_id="" data-estatus="' . $contrato['estatus'] . '" data-pagos_concretados="' . $contrato['pagos_concretados'] . '" data-placement="top" data-toggle="tooltip" id="btnConvertir" title="Convertir estancia"  value="' . $contrato['id_folio'] . '"><i class="fas fa-cog"></i> Convertir estancia</a>' : '';

        $btn .= (Auth::user()->can('editar_contrato')) ? ' <a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-pagos_concretados="' . $contrato['pagos_concretados'] . '" data-placement="top" data-toggle="tooltip" id="btnEditarContrato" title="Editar contrato"  value="' . $contrato['id_folio'] . '"><i class="fas fa-edit"></i> Editar</a>' : '';

        $btn .= (Auth::user()->can('metodo_de_pago')) ? '<a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-pagos_concretados="' . $contrato['pagos_concretados'] . '" data-placement="top" data-route="' . route('contrato.show_metodo_pago', $contrato['id_folio']) . '" data-toggle="tooltip" id="btnMetodoPago" title="Cambiar metodo de cobro"  value="' . $contrato['id_folio'] . '"><i class="fas fa-money-bill-wave-alt"></i> Metodo de pago</a>' : '';

        $btn .= (Auth::user()->can('recalcular_contrato')) ? '<a class="dropdown-item btnCalPagos" data-estatus="' . $contrato['estatus'] . '" data-pagos_concretados="' . $contrato['pagos_concretados'] . '" data-placement="top" data-toggle="tooltip" href="#modalCalculador" id="btnCalPagos" title="Calcular pagos"  value="' . $contrato['id_folio'] . '" data-contrato_id="' . $contrato['id_folio'] . '"><i class="fas fa-calculator"></i> Recalcular pagos</a>' : '';

        $btn .= (Auth::user()->can('calidad')) ? ' <a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-placement="top" data-toggle="tooltip" id="btnCalidad" data-url="' . route('contratos.calidad', $contrato['id_folio']) . '" title="Cargar calidad"  value="' . $contrato['id_folio'] . '"><i class="fas fa-check"></i> Cargar calidad</a>' : '';

        $btn .= ($contrato['estatus_calidad'] > 0 && Auth::user()->can('ver_calidad')) ? ' <a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-placement="top" data-toggle="tooltip" id="btnVerCalidad" data-url="' . route('contratos.ver_calidad', $contrato['id_folio']) . '" title="Ver respaldos"  value="' . $contrato['id_folio'] . '"><i class="fas  fa-paperclip"></i> Ver calidad</a>' : '';

        $btn .= (Auth::user()->can('agregar_pago')) ? ' <a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-pagos_concretados="' . $contrato['pagos_concretados'] . '" data-placement="top" data-toggle="tooltip" id="btnAddPago" title="Agregar pago"  value="' . $contrato['id_folio'] . '"><i class="fas fa-plus"></i> Agregar pago</a>' : '';

        $btn .= (Auth::user()->can('autorizar_folio')) ? ' <a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-pagos_concretados="' . $contrato['pagos_concretados'] . '" data-placement="top" data-toggle="tooltip" id="btnAutorizar" title="Autorizar Folio"  value="' . $contrato['id_folio'] . '"><i class="fas fa-key"></i> Autorizar</a>' : '';

        // desvincular folio de reservacion

        $btn .= ($contrato['numero_reservaciones'] > 0 && Auth::user()->can('agregar_pago')) ? ' <a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-placement="top" data-toggle="tooltip" id="btnDesvincular" title="Desvincular contrato de reservacion"   data-contrato_id="' . $contrato['id_folio'] . '" data-url="' . route('contratos.reservaciones_vinculadas', $contrato['id_folio']) . '"><i class="fas fa-chain-broken"></i> Desvincular folio</a>' : '';

        $btn .= (Auth::user()->can('delete')) ? ' <a class="dropdown-item" data-estatus="' . $contrato['estatus'] . '" data-placement="top" data-toggle="tooltip" id="btnDeleteContrato" data-url="' . route('contratos.destroy', $contrato['id_folio']) . '" title="Eliminar contrato"  value="' . $contrato['id_folio'] . '"><i class="fas fa-trash"></i> Eliminar</a>' : '';

        $btn = '<div class="btn-group">
              <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opciones
              </button>
              <div class="dropdown-menu">
               ' . $btn . '
              </div>
            </div>';

        return $btn;
    }
    */

    /**
     * Agrega el historial al registro del cliente
     * Autor: Diego Enrique Sanchez
     * Creado: 2021-08-28
     * @param Request $request
     * @return Response $data
     */
    public function add_log(Request $request)
    {
        $data['success'] = false;
        $user            = User::findOrFail($request->user_id);
        $log             = "<h2 class='" . Auth::user()->role . "'>" . Auth::user()->username . " (" . Auth::user()->fullName . ") <span class='nota small'>" . date('Y-m-d H:i:s') . "</span></h2><ul class='" . Auth::user()->role . "'><li>" . $request->log . "</li></ul>";

        $nuevo_log = $log . $user->historico;

        $user->historico = $nuevo_log;
        if ($user->save()) {
            $data['success'] = true;
            $data['log']     = strstr($user->historico, '</ul>', true);
        }
        return response()->json($data);
    }

    public function listar_usuarios($user_id = null)
    {
        /*if (isset($user_id)) {
            $padre_id = Padre::where('user_id', $user_id)->first()->id;
        } else {
            $padre_id = Padre::where('user_id', Auth::user()->id)->first()->id;
        }*/
        //$users = User::with('contratos')->where('padre_id', $padre_id)->get();

        $users = (new User)->sp_clientes_porUsuario(Auth::user()->id);
        $data     = array();
        $i        = 1;
        $btn      = '';
        $btnPagos = '';

        foreach ($users['data'] as $user) {
            $btn .= '<a href="' . route('users.show', $user['user_id']) . '" class="btn btn-dark btn-xs"><i class="fas fa-eye"></i></a>';

            /*$data[] = array(
                "0" => $user->fullName,
                "1" => $user->username,
                "2" => $user->convenio->empresa_nombre,
                "3" => $user->diffForhumans(),
                "4" => $btn,
            );*/
            $data[] = array(
                "0" => $user['nombre_cliente'],
                "1" => $user['username'],
                "2" => $user['empresa_nombre'],
                "3" => Carbon::create($user['created'])->diffForHumans(),
                "4" => $btn,
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

    public function show_admin()
    {
        $this->authorize('show_admin', Auth::user());
        $sales_group = Salesgroup::all();
        return view('admin.users.admin', compact('sales_group'));
    }

    /**
     * Listar usuarios administrativos
     * @return response
     */
    public function listar_administrativos_old()
    {
        $users = User::whereNotIn('role', ['client'])->orderBy('id', 'DESC')->get();

        $data      = array();
        $i         = 1;
        $btn       = '';
        $btnPagos  = '';
        $btnActivo = '';

        foreach ($users as $user) {
            $btn .= '<a href="' . route('users.show', $user->id) . '" class="btn btn-info btn-xs mr-1"><i class="fas fa-eye"></i></a>';
            $btn .= '<a href="' . route('users.edit', $user->id) . '" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></a>';

            $class     = ($user->permitir_login == 1) ? 'info' : 'danger';
            $btnActivo = '<button type="button" data-url="' . route('users.update_login', $user->id) . '" id="activo" data-user_id="' . $user->id . '" data-activo="' . $user->permitir_login . '" class="btn btn-' . $class . ' btn-xs">' . $user->login . '</button>';

            $data[] = array(
                "0" => $user->id,
                "1" => $user->fullName,
                "2" => $user->username,
                "3" => ($user->equipo) ? $user->equipo->title : __('messages.sin_asignar'),
                "4" => $user->perfil,
                "5" => $user->diffForhumans(),
                "6" => $btn,
                "7" => $btnActivo,

            );
            $btn       = '';
            $btnActivo = '';
            $i++;
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
     * Autor: ISW. Diego Sanchez
     * Creado: 2022-10-11
     * Listado de usuarios tipo administrativo server side evitando sobre carga de datos
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function listar_administrativos(Request $request)
    {

        // dd($request->all());
        $users = User::whereNotIn('role', ['client'])->orderBy('id', 'DESC');

        if ($request->mostrar != 'todos') {
            $users->where('role', $request->mostrar);
        }
        if ($request->equipo != 'todos') {
            $users->where('salesgroup_id', $request->equipo);
        }

        return DataTables::eloquent($users)

            ->editColumn('id', function ($users) {
                return ucwords($users->id);
            })

            ->editColumn('nombre', function ($users) {
                return $users->fullName;
            })

            ->editColumn('username', function ($users) {
                return $users->username;
            })

            ->addColumn('equipo', function ($users) {
                return ($users->equipo) ? $users->equipo->title : __('messages.sin_asignar');
            })
            ->editColumn('role', function ($users) {
                return $users->perfil;
            })
            ->editColumn('created', function ($users) {
                return $users->diffForhumans();
            })
            ->addColumn('activo', function ($users) {
                $class     = ($users->permitir_login == 1) ? 'info' : 'danger';
                $btnActivo = '<button type="button" data-url="' . route('users.update_login', $users->id) . '" id="activo" data-user_id="' . $users->id . '" data-activo="' . $users->permitir_login . '" class="btn btn-' . $class . ' btn-xs">' . $users->login . '</button>';

                return $btnActivo;
            })
            ->addColumn('actions', function ($users) {
                $btn = '';

                if (Auth::user()->can('view', $users)) {
                    $btn .= '<a href="' . route('users.show', $users->id) . '" target="_blank" class="btn btn-info btn-xs mr-1"><i class="fas fa-eye"></i></a>';

                }
                if (Auth::user()->can('update', $users)) {
                    $btn .= '<a href="' . route('users.edit', $users->id) . '" target="_blank" class="btn btn-success btn-xs mr-1"><i class="fas fa-edit"></i></a>';
                }
                // if (Auth::user()->can('delete', $users)) {
                //     $btn .= '<a href="javascript:void(0)" value="' . $users->id . '" class="btn btn-danger btn-xs" id="btnEliminar"><i class="fas fa-trash-alt"></i></a>';
                // }
                return $btn;
            })
            ->rawColumns(['id', 'nombre', 'username', 'equipo', 'actions', 'activo', 'role', 'created'])
            ->make(true);
    }

    public function show_clientes()
    {
        $this->authorize('show_client', Auth::user());
        $users = User::with('padre')->whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        })
            ->where('role', 'client')
            ->paginate(15);

        return view('admin.users.clientes', compact('users'));
    }

    /**
     * Listar usuarios clientes
     * @return response
     */
    public function listar_clientes()
    {
        $users = User::with('padre')->whereHas('convenio', function ($q) {
            $q->where('paise_id', env('APP_PAIS_ID'));
        })
            ->where('role', 'client');

        return Datatables::eloquent($users)

            ->editColumn('id', function ($users) {
                return ucwords($users->id);
            })
            ->editColumn('nombre', function ($users) {
                return '<a target="_blank" href="' . route('users.show', $users->id) . '" class="">' . $users->fullName . '</a>';
            })
            ->editColumn('username', function ($users) {
                return $users->username;
            })
            ->editColumn('padre_id', function ($users) {
                return (isset($users->padre)) ? $users->padre->title : 'S/R';
            })
            ->editColumn('convenio_id', function ($users) {
                return (isset($users->convenio)) ? $users->convenio->empresa_nombre : 'S/R';
            })
            ->addColumn('contratos', function ($users) {
                return count($users->contratos);
            })
            ->editColumn('created', function ($users) {
                return $users->diffForhumans();
            })
            ->addColumn('actions', function ($users) {
                $btn = '';
                $btn .= '<a href="' . route('users.show', $users->id) . '" target="_blank" class="btn btn-info btn-xs mr-1"><i class="fas fa-eye"></i></a>';
                $btn .= '<a href="' . route('users.edit', $users->id) . '" target="_blank" class="btn btn-success btn-xs mr-1"><i class="fas fa-edit"></i></a>';
                // $btn .= '<button data-url="'.route('users.destroy', $users->id). '" data-user_id="'.$users->id.'" id="btnEliminar" type="button" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>';
                return $btn;
            })
            ->rawColumns(['id', 'nombre', 'username', 'padre_id', 'actions', 'contratos', 'convenio_id', 'created'])
            ->make(true);

    }

    public function update_login(Request $request, $id)
    {
        $user            = User::findOrFail($id);
        $data['success'] = false;
        if ($user) {
            if ($request->estatus == 0) {
                $user->permitir_login = 1;
            } else {
                $user->permitir_login = 0;
            }

            $user->save();
            $data['success'] = true;
        }

        return response()->json($data);
    }

    public function getUser()
    {
        return response()->json(Auth::user());
    }

    public function configurar_mail()
    {
        return view('admin.users.config_mail');
    }

    public function config_mail(Request $request)
    {

        // dd($request->all());
        $config             = new ConfigUser;
        $config->user_id    = $request->user_id;
        $config->type       = $request->type;
        $config->host       = $request->host;
        $config->port       = $request->port;
        $config->email      = $request->email;
        $config->password   = $request->password;
        $config->encryption = $request->encryption;
        $config->from       = $request->email;
        $config->from_name  = $request->from_name;

        if ($config->save()) {
            return redirect()->route('dashboard');
        }
    }

    public function perfil()
    {
        $user = Auth::user();

        $inicios = Incidencia::where('user_id', $user->id)->orderBy('id', 'DESC')->limit(10)->get();

        return view('admin.users.perfil', compact('user', 'inicios'));
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creadi; 2023-06-20
     * Descripcion: Actualizacion de datos del usuario logueado
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_perfil(Request $request, $id)
    {
        $data['success'] = false;

        $method   = $request->method();
        $user     = User::findOrFail($id);
        $validate = $this->validar_perfil($request, $method, $user->id);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        $fecha = Carbon::now();

        $user->username = $request->username;

        if ($request->password) {
            if (env('APP_ENV') == 'Production') {
                $pass           = $this->get_password($request->password);
                $user->password = $pass['password'];
            }
            $user->clave     = base64_encode($request->password);
            $user->pass_hash = bcrypt($request->password);
        }

        $user->modified           = $fecha;
        $user->nombre             = $request->nombre;
        $user->apellidos          = $request->apellidos;
        $user->direccion          = $request->direccion;
        $user->direccion2         = $request->direccion2;
        $user->ciudad             = (isset($request->delegacion)) ? $request->delegacion : $request->ciudad;
        $user->pais               = (($request->pais) ? $request->pais : (env('APP_PAIS_ID') == 1)) ? 'México' : 'United States';
        $user->telefono           = $request->telefono;
        $user->telefono_casa      = $request->telefono_casa;
        $user->telefono_oficina   = $request->telefono_oficina;
        $user->provincia          = $request->estado;
        $user->codigo_postal      = $request->cp;
        $user->cp_id              = $request->colonia;
        $user->numero_de_empleado = $request->no_empleado;
        $user->RFC                = $request->rfc;
        $user->cumpleanos         = $request->cumpleanos;

        if ($user->save()) {
            if (isset($request->reenviar_contraseña)) {
                Mail::to($user->username)->send(new SendNewPassword($user));
            }

            if ($user->role != 'client') {
                if ($user->admin_padre == null) {
                    Padre::create([
                        'user_id'              => $user->id,
                        'title'                => $user->username,
                        'correo_institucional' => $user->username,
                        'nombre'               => $user->fullName,
                    ]);
                }

            }

            $data['success'] = true;
            // $data['url']     = route('users.show', $user->id);
        }

        return response()->json($data);
    }

    public function validar_email($username)
    {
        // dd($username);
        $data['success']     = false;
        $data['user_alerta'] = AlertaMx::where('email', $username)->first();
        if ($data['user_alerta'] != null) {
            $data['success']  = true;
            $data['convenio'] = Convenio::where('empresa_nombre', $data['user_alerta']['empresa'])->first(['id', 'empresa_nombre']);
        }
        return response()->json($data);
    }
}
