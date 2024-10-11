<?php

namespace App\Http\Controllers\Usa;

use App;
use App\Contrato;
use App\Convenio;
// use App\Converge\ConvergePayment;
use App\Estancia;
use App\Events\CreateCardUsa;
use App\Events\CreateUser;
use App\Helpers\ComisionesHelper;
use App\Helpers\PagosHelper;
use App\Http\Controllers\Controller;
use App\Mail\NewPurchase;
use App\Mail\NewUserNotification;
use App\Mail\Usa\NotificacionCompraUsa;
use App\Tarjeta;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;
use Mail;
use Session;
use Stripe;

class ComprarController extends Controller
{
    private $comisiones;
    private $pagos;
    private $converge;

    protected $con;
    protected $con_id;

    public function __construct()
    {
        $this->comisiones = new ComisionesHelper;
        $this->pagos      = new PagosHelper;
        // $this->converge   = new ConvergePayment;

        $this->con    = env('APP_CONV_USA');
        $this->con_id = env('APP_CONV_ID');
    }
    /**
     * Autor:    Diego Enrique Sanchez
     * Creado:   2021-08-19
     * Accion:   validacion del formulario de registro cliente
     * @param    request
     * @return   validacion
     */
    public function validar_form(Request $request, $id = null)
    {
        $validator = \Validator::make($request->all(), [
            'nombre'      => (!Auth::check()) ? 'required | string | max:40' : '',
            'apellidos'   => (!Auth::check()) ? 'required | string | max:40' : '',
            'username'    => (!Auth::check()) ? 'required | email  | unique:users' : '',
            'password'    => (!Auth::check()) ? 'required | string | min:8 | confirmed' : '',
            // 'direccion'   => (!Auth::check()) ? 'required | string | max:255' : '',
            // 'telefono'    => (!Auth::check()) ? 'required | numeric | min:10' : '',
            // 'ciudad'      => (!Auth::check()) ? 'required' : '',
            // 'estado'      => (!Auth::check()) ? 'required' : '',
            // 'cp'          => (!Auth::check()) ? 'required' : '',
            'estancia_id' => (!Auth::check()) ? 'required' : '',
        ]);
        return $validator;
    }

    /**
     * Autor:    Diego Enrique Sanchez
     * Creado:   2021-08-23
     * Accion:   validacion del formulario de pagos
     * @param    request
     * @return   validacion
     */
    public function validar_form_card(Request $request, $id = null)
    {

        $validator = \Validator::make($request->all(), [
            'holder_name'          => ($request->holder_name || $request->card_number || $request->expiratino || $request->cvv2) ? 'required | string | max:40' : '',
            'card_number'          => ($request->holder_name || $request->card_number || $request->expiratino || $request->cvv2) ? 'required | string | max:19 | min:16' : '',
            'expiration'           => ($request->holder_name || $request->card_number || $request->expiratino || $request->cvv2) ? 'required' : '',
            'cvv2'                 => ($request->holder_name || $request->card_number || $request->expiratino || $request->cvv2) ? 'required' : '',
            'enganche'             => 'accepted',
            'terminos'             => 'accepted',
            // 'g-recaptcha-response' => 'required | captcha',
            // 'direccion'            => 'required | string | max:255',
            // 'ciudad'               => 'required',
            // 'estado'               => 'required',
            // 'cp'                   => 'required',
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
    public function create(Request $request)
    {

        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            return response()->json(['success' => false, 'errors' => $validate->errors()]);
        }

        try {
            $estancia    = Estancia::findOrFail($request->estancia_id);
            $convenio_id = empty($estancia->convenio->id) ? $this->con_id : $estancia->convenio->id;

            $user['estancia_id'] = $request->estancia_id;
            $user['system_register'] = 'mtb';
            $user['convenio_id'] = (session('convenio_id')) ? session('convenio_id') : $convenio_id;

            if (Auth::check()) {
                $user['nombre']    = Auth::user()->nombre;
                $user['apellidos'] = Auth::user()->apellidos;
                $user['telefono']  = Auth::user()->telefono;
                $user['username']  = Auth::user()->username;
                $user['cp']          = Auth::user()->codigo_postal;
                $user['ciudad']      = Auth::user()->ciudad;
                $user['estado']      = Auth::user()->provincia;
                $user['direccion']   = Auth::user()->direccion;
                $user['estancia_id'] = $request->estancia_id;
                $user['convenio_id'] = (session('convenio_id')) ? session('convenio_id') : $convenio_id;
                $user['num_pax']     = $request->num_pax;
                $data['user']        = $user;
            } else {
                $user = array();

                // try {
                //     $pass              = $this->get_password($request->password);
                // $user['password']  = $pass['password'];
                $user['password'] = base64_encode($request->password);
                // $user['user_hash'] = $pass['user_hash'];
                // } catch (Exception $e) {

                // }

                $user['nombre']    = $request->nombre;
                $user['apellidos'] = $request->apellidos;
                $user['telefono']  = $request->telefono;
                $user['username']  = $request->username;

                $user['clave']     = base64_encode($request->password);
                $user['pass_hash'] = bcrypt($request->password);
                $user['cp']          = $request->cp;
                $user['ciudad']      = $request->ciudad;
                $user['estado']      = $request->estado;
                $user['direccion']   = $request->direccion;
                $user['estancia_id'] = $request->estancia_id;
                $user['convenio_id'] = (session('convenio_id')) ? session('convenio_id') : $convenio_id;
                $user['num_pax']     = $request->num_pax;
                $data['user']        = $user;
                $new_user            = event(new CreateUser($user));
                $user_id             = $new_user[0]['id'];
                // $username = $user[0]['username'];

                try {
                    Auth::loginUsingId($user_id);
                    Log::notice('Registro y logueo exitoso de usuario: ' . $new_user[0]->id);
                } catch (Exception $e) {
                    Log::warning('No se pudo iniciar sesion del usuario: ' . $new_user[0]->id);
                }

            }

            Session::put('user', $user);
            if ($user['estancia_id'] == 37727 || $user['estancia_id'] == 37728) {
                $data['card'] = route('process-payment.payment_lat');
            } else {
                $data['card'] = route('process-payment.payment');
            }

            $data['success'] = true;

        } catch (Exception $ex) {
            $data['success']    = false;
            $data['exceptions'] = $ex;

        }
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
        // Mail::to($username)->send(new NewUserNotification(Auth::user()));
        $user = session('user');

        $estancia_id = $user['estancia_id'];
        $estancia = Estancia::findOrFail($estancia_id);
        $data['tarjeta_id'] = null;
        try {
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $data['payment'] = Stripe\Charge::create ([
                    "amount" => intval($estancia->enganche_especial * 100),
                    "currency" => "usd",
                    "source" => $request->token_id,
                    "description" => "This is test payment",
                    'receipt_email' => Auth::user()->username,
            ]);

            if ($data['payment']['status'] == 'succeeded') {        
                $data['user']['nombre']    = Auth::user()->nombre;
                $data['user']['apellidos'] = Auth::user()->apellidos;
                $data['user']['telefono']  = Auth::user()->telefono;
                $data['user']['email']     = Auth::user()->username;

                /**
                 * Datos de la tarjeta capturados en el formulario de metodo de pago
                 */
                $vence = explode('/', $request->expiration);

                $mes = $vence[0];
                $ano = $vence[1];

                $data['tarjeta']['holder_name']      = $request->holder_name;
                $data['tarjeta']['card_number']      = str_replace('-','',$request->card_number);

                $data['tarjeta']['expiration_month'] = $mes;
                $data['tarjeta']['expiration_year']  = $ano;
                $data['tarjeta']['cvv2']             = $request->cvv2;
                $data['tarjeta']['brand']            = $data['payment']['source']['brand']; 
                $data['tarjeta']['funding']            = $data['payment']['source']['funding']; 
                $data['amount']                      = $estancia->enganche_especial;


                /*
                 * Validamos que si existe la tarjeta regresamos el id para asociarla al contrato
                 * En caso contrario creamos la tarjeta y obtenermos el id 
                 */
                if ($validar = $this->validar_tarjeta_cliente($data['tarjeta'])) {
                    $data['tarjeta_id'] = $validar->id;
                }else{
                    $data['tarjeta_id'] = $this->crear_tarjeta($data['tarjeta'])['id'];
                }

                $contrato = $this->generar_contrato($estancia_id, Auth::id(), $data['tarjeta_id'], $user);

                $pago_enganche = $this->pagos->generar_pago_engache($contrato, 'Pagado');

                if ($estancia->cuotas == 12) {
                    $pagos_segmentos = $this->pagos->generar_pagos_mensual($contrato->id);
                } else {
                    $pagos_segmentos = $this->pagos->generar_pagos_quincenales($contrato->id);
                }

                $comisiones = $this->comisiones->generar_comisiones($contrato->id);
                

                try {
                    $this->obtener_contrato_pdf($contrato);
                    Mail::to(Auth::user()->username)->send(new NewPurchase($contrato));
                } catch (Exception $e) {
                    Log::error('No se pudo enviar el pdf del contrato: ' . $contrato->id);
                }

                Mail::to(env('NOTIFICACION_EMAIL'))->send(new NotificacionCompraUsa($contrato));
                $data['auth'] = Auth::user();
                $data['url']     = route('process-payment.finalizar_compra', $contrato->id);
                $data['success'] = true;

            }
        } catch (\Exception $e) {
            $data['error_stripe'] = $e->getMessage();
            $data['success'] = false;
            $data['payment'] = false;
        }
   
        return response()->json($data);
    }



    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-01-17
     * Validammos la tarjeta del cliente
     * si existe el registro retornamos el objeto para obtener el id
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function validar_tarjeta_cliente($data)
    {
        $tarjeta = Tarjeta::where([
            'numero' => $data['card_number'],
            'mes'    => $data['expiration_month'],
            'ano'    => $data['expiration_year'],
            'cvv2'   => $data['cvv2'],
        ])->first();

        return $tarjeta;
    }

    public function crear_tarjeta($data)
    {

        $bank_id = 87;

        $fecha = Carbon::now();

        $tarjeta           = new Tarjeta;
        $tarjeta->user_id  = Auth::user()->id;
        $tarjeta->banco_id = $bank_id;
        $tarjeta->name     = $data['holder_name'];
        $tarjeta->banco    = $data['brand'];
        $tarjeta->numero   = $data['card_number'];
        $tarjeta->tipo     = (isset($data['funding']) && $data['funding'] == 'credit') ? 'Credito' : 'Debito';

        $tarjeta->mes                  = $data['expiration_month'];
        $tarjeta->ano                  = $data['expiration_year'];
        $tarjeta->cvv2                 = $data['cvv2'];
        $tarjeta->estatus              = 'Confirmada';
        $tarjeta->historico_de_pagos   = 'al_corriente';
        $tarjeta->created              = $fecha;
        $tarjeta->importado            = 0;
        $tarjeta->tipocuenta           = '03';
        $tarjeta->autorizo             = 1;
        $tarjeta->agreeterms           = 1;
        $tarjeta->firstpaymentdeducted = 0;
        $tarjeta->save();
        return $tarjeta;
    }

    public function generar_contrato($estancia, $user_id, $tarjeta, $user_sesion = null)
    {
        // dd($user_sesion);
        $est     = Estancia::findOrFail($estancia);
        $cli     = User::findOrFail($user_id, ['id', 'username', 'convenio_id', 'nombre', 'apellidos']);
        $success = false;
        $fecha   = Carbon::now();

        $contrato                                  = new Contrato;
        $contrato->user_id                         = $user_id;
        $contrato->convenio_id                     = (session('convenio_id')) ? session('convenio_id') : $cli->convenio_id;
        $contrato->estancia_id                     = $est->id;
        $contrato->tarjeta_id                      = $tarjeta;
        $contrato->paquete                         = $est->title;
        $contrato->estatus                         = 'comprado';
        $contrato->precio_de_compra                = ($user_sesion['num_pax']) ? ((54 * 12) * $user_sesion['num_pax']) : $est->precio;
        $contrato->pago_con_nomina                 = 0;
        $contrato->pago_con_otras_tarjetas         = 0;
        $contrato->estatus_de_pagos                = 0;
        $contrato->padre_id                        = 246;
        $contrato->noches                          = $est->noches;
        $contrato->adultos                         = ($user_sesion['num_pax']) ? $user_sesion['num_pax'] : $est->adultos;
        $contrato->ninos                           = $est->ninos;
        $contrato->divisa                          = $est->divisa;
        $contrato->created                         = $fecha;
        $contrato->modified                        = $fecha;
        $contrato->edad_max_ninos                  = $est->edad_max_ninos;
        $contrato->layout_processed                = 0;
        $contrato->via_serfin                      = 0;
        $contrato->estatus_comisiones              = 'sin_procesar';
        $contrato->comisiones_actualizadas         = 0;
        $contrato->reservacion_en_proceso          = 0;
        $contrato->importado                       = 0;
        $contrato->tipo_llamada                    = 'WB';
        $contrato->usd_mxp                         = 0;
        $contrato->autorizo                        = 0;
        $contrato->agreeterms                      = 0;
        $contrato->numero_de_empleado              = 0;
        $contrato->alerta_user_enviada             = 0;
        $contrato->alerta_compra                   = 0;
        $contrato->alerta_compra_fecha             = $fecha;
        $contrato->alerta_compra_enviada_a         = $fecha;
        $contrato->fecha_primer_segmento           = $fecha;
        $contrato->fecha_primer_descuento_contrato = $fecha;
        $contrato->pagos                           = 0;
        $contrato->cantidad_pagos_hechos           = 0;

        // dd($contrato);
        if ($contrato->save()) {
            return $contrato;
        }

        // return true;
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

    public function get_password($password)
    {
        $response = Http::get('https://pacifictravels.mx/apirest/view/' . $password . '.json');
        if ($response->getBody()) {
            $res = json_decode($response->getBody(), true);
        }
        return $res;
    }

    /**
     * Muestra la vista correspondiente para realizar el cargo con tarjeta
     * Diego Enrique Sanchez
     * 2021-08-21
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_card(Request $request)
    {

        if (Auth::check()) {
            $tarjetas = Tarjeta::where('user_id', Auth::user()->id)->get();
        } else {
            $tarjetas = false;
        }

        $user = session()->get('user');
        if (!empty($user)) {
            $user     = session()->get('user');
            $estancia = Estancia::findOrFail($user['estancia_id']);
            return view('pagina.usa.add_card', compact('user', 'estancia', 'tarjetas'));
        }
        abort(419);
    }

    /**
     * Muestra la vista correspondiente para realizar el cargo con tarjeta
     * Diego Enrique Sanchez
     * 2022-11-07
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function payment_card_lat(Request $request)
    {

        if (Auth::check()) {
            $tarjetas = Tarjeta::where('user_id', Auth::user()->id)->get();
        } else {
            $tarjetas = false;
        }

        // dd($tarjetas);

        $user = session()->get('user');
        // dd($user);
        if (!empty($user)) {
            $user     = session()->get('user');
            $estancia = Estancia::findOrFail($user['estancia_id']);
            return view('pagina.usa.add_card_lat', compact('user', 'estancia', 'tarjetas'));
        }
        abort(419);
    }

    public function finalizar_compra($contrato_id)
    {
        $contrato = Contrato::findOrFail($contrato_id);
        if ($contrato) {
            return view('pagina.usa.finalizar_compra', compact('contrato'));
        }
        abort('404');
    }

    public function mostrar_contrato($id)
    {
        $con = Contrato::findOrFail($id);

        $contrato = $this->procesar_datos_contrato($con);
        $formato  = $this->construir_contrato($contrato, $con);

        return response()->json($formato);
    }

    public function obtener_contrato_pdf($con)
    {
        // $con      = Contrato::findOrFail($con);
        $contrato = $this->procesar_datos_contrato($con);
        $formato  = $this->construir_contrato($contrato, $con);

        $name = 'C' . $con->id . '.pdf';
        $path = public_path() . '/files/contratos_usa/' . $name;
        $pdf  = App::make('dompdf.wrapper');
        $pdf->loadHTML($formato);
        $pdf->save($path);

        return $name;

    }

    public function construir_contrato($emailVars, $contrato)
    {

        if ($contrato['Estancia']['descripcion_formal_es_contrato_completo'] == false) {
            if ($contrato['Contrato']['pago_con_nomina']) {
                $contrato_cuerpo = $contrato['Convenio']['contrato_nomina'];
            } else {
                $contrato_cuerpo = $contrato['Convenio']['contrato'];
            }
        } else {
            $contrato_cuerpo = $contrato['Estancia']['descripcion_formal'];
            $contrato_cuerpo = str_replace('[estancia]', '', $contrato_cuerpo);
            $contrato_cuerpo = str_replace(' noches Temporada: ______________________<br>', '<br>', $contrato_cuerpo);
        }

        for ($i = 2; $i >= 1; $i--) {
            foreach ($emailVars as $var => $data) {
                $contrato_cuerpo = str_replace('[' . $var . ']', $data, $contrato_cuerpo);
            }
        }
        return $contrato_cuerpo;
    }

    public function descargar_contrato($id)
    {
        $con      = Contrato::findOrFail($id);
        $contrato = $this->procesar_datos_contrato($con);
        $formato  = $this->construir_contrato($contrato, $con);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($formato);
        $pdf->download('C' . $con->id . '.pdf');
        return $pdf->stream('C' . $con->id . '.pdf');
    }

    public function procesar_datos_contrato($contratoData)
    {

        $emailVars = array();

        //Acerca del Contrato
        $emailVars['contrato_id']       = $contratoData->id;
        $emailVars['fecha_de_contrato'] = (count($contratoData->pagos_contrato) > 0) ? $contratoData->pagos_contrato[0]->fecha_de_cobro : ': pendiente';
        $emailVars['first-installment'] = (count($contratoData->pagos_contrato) > 0) ? $contratoData->pagos_contrato[0]->fecha_de_cobro : ': pendiente';
        $emailVars['fechadecontrato']   = $emailVars['fecha_de_contrato'];
        $emailVars['fecha-de-contrato'] = $contratoData->created;

        // $emailVars['nombre_hotel']   = $contratoData['Hotel']['nombre'];
        $emailVars['nombre_destino'] = $contratoData->paquete;

        if ((count($contratoData->pagos_contrato) > 0)) {
            if ($contratoData->pagos_contrato[0]->segmento == 0) {
                foreach ($contratoData->pagos_contrato as $pago) {
                    if ($pago->segmento > 0) {
                        $emailVars['fecha_de_contrato'] = $pago->fecha_de_cobro;
                        break;
                    }
                }
            }
        }

        $emailVars['precio_de_compra'] = $contratoData->precio_de_compra . ' ' . $contratoData->divisa;
        $emailVars['preciodecompra']   = $emailVars['precio_de_compra'];
        $emailVars['precio-de-compra'] = $emailVars['precio_de_compra'];

        $emailVars['metodo_de_compra'] = ($contratoData->pago_con_nomina) ? "Nómina" : "Banca";
        $emailVars['metododecompra']   = $emailVars['metodo_de_compra'];
        $emailVars['metodo-de-compra'] = $emailVars['metodo_de_compra'];

        //Arreglo temporal
        switch ($contratoData->paquete) {
            case 'ti':
                $emailVars['dias_noches']    = '3 días 2 noches';
                $emailVars['adultos']        = 2;
                $emailVars['ninos']          = 2;
                $emailVars['edad_max_ninos'] = 12;
                $emailVars['cuotas_title']   = 'MENSUALES';
                break;
            case 'ii':
                $emailVars['dias_noches']    = '5 días 4 noches';
                $emailVars['adultos']        = 2;
                $emailVars['ninos']          = 2;
                $emailVars['edad_max_ninos'] = 12;
                $emailVars['cuotas_title']   = 'MENSUALES';
                break;
            default:
                $noches = $contratoData->noches;
                $dias   = $contratoData->noches + 1;

                $emailVars['dias_noches']      = (isset($contratoData->convenio->paise_id) && $contratoData->convenio->paise_id == 11) ? $contratoData->estancia->temporada : $dias . ' días ' . $noches . ' noches';
                $emailVars['fecha_nacimiento'] = (isset($contratoData->cliente->cumpleanos)) ? $contratoData->cliente->cumpleanos : 'Sin confirmar';
                $emailVars['adultos']          = $contratoData->adultos;
                $emailVars['ninos']            = $contratoData->ninos;
                $emailVars['edad_max_ninos']   = $contratoData->edad_max_ninos;
                $emailVars['cuotas']           = $contratoData->estancia->cuotas;
                // La siguiente linea manda al procesador del envío de contrato el
                // espacio agregado de la descripción formal de la estancia.
                $emailVars['estancia']       = $contratoData->estancia->descripcion_formal;
                $emailVars['estancia_title'] = $contratoData->estancia->title;
                $emailVars['ESTANCIA_TITLE'] = $contratoData->estancia->title;
                $emailVars['noches']         = $contratoData->noches;
                $emailVars['hotel_name']     = $contratoData->estancia->hotel_name;

                switch ($emailVars['cuotas']) {
                    case 48:
                        $emailVars['cuotas_title'] = 'SEMANALES';
                        break;
                    case 24:
                        $emailVars['cuotas_title'] = 'QUINCENALES';
                        break;
                    case 12:
                        $emailVars['cuotas_title'] = 'MENSUALES';
                        break;
                }
        }

        $emailVars['noches']       = $contratoData->noches;
        $emailVars['hotel_name']   = $contratoData->hotel_name;
        $emailVars['edadmaxninos'] = $emailVars['edad_max_ninos'];

        //Acerca del Convenio
        $emailVars['empresa_nombre'] = $contratoData->convenio->empresa_nombre;

        //Acerca del Usuario
        $emailVars['cliente'] = $contratoData->cliente->nombre . ' ' . $contratoData->cliente->apellidos;

        $emailVars['telefono']         = $contratoData->cliente->telefono;
        $emailVars['telefono_casa']    = $contratoData->cliente->telefono_casa;
        $emailVars['telefono_oficina'] = $contratoData->cliente->telefono_oficina;

        $emailVars['ciudad']            = $contratoData->cliente->ciudad . ", " . $contratoData->cliente->provincia;
        $emailVars['city']              = $contratoData->cliente->ciudad;
        $emailVars['estate']            = $contratoData->cliente->provincia;
        $emailVars['e-mail']            = $contratoData->cliente->username;
        $emailVars['codigo_postal']     = $contratoData->cliente->codigo_postal;
        $emailVars['cumpleanos']        = $contratoData->cliente->cumpleanos;
        $emailVars['rfc']               = $contratoData->cliente->RFC;
        $emailVars['direccion_cliente'] = $contratoData->cliente->direccion . " " . $contratoData->cliente->direccion2;

        //RYM Monto de cuotas

        // Autor: Diego Enrique Sanchez
        //se calcula el monto que se pagara
        //debera cambiar si la estancia es esoecual y validar el enganche
        if ($contratoData->estancia->est_especial == 1) {
            // $emailVars['monto_cuotas_num']  = ($contratoData['Estancia']['precio'] - $contratoData['Estancia']['enganche_especial']) / $contratoData['Estancia']['cuotas'];
            $emailVars['monto_cuotas_num']  = $contratoData->precio_de_compra / $contratoData->estancia->cuotas;
            $emailVars['monto_cuotas_str']  = $emailVars['monto_cuotas_num'] . ' ' . $contratoData->divisa;
            $emailVars['enganche_especial'] = "A one time only deposit fee for the amount of <strong>" . $contratoData->estancia->enganche_especial . ' ' . $contratoData->divisa . "</strong>, non refundable.";
        } else {
            $emailVars['monto_cuotas_num']  = $contratoData->precio_de_compra / $contratoData->estancia->cuotas;
            $emailVars['monto_cuotas_str']  = $emailVars['monto_cuotas_num'] . ' ' . $contratoData->divisa;
            $emailVars['enganche_especial'] = '';
        }

        /*$emailVars['monto_cuotas_num'] = $contratoData['Contrato']['precio_de_compra'] / $contratoData['Estancia']['cuotas'];
        $emailVars['monto_cuotas_str'] = $text->currency($emailVars['monto_cuotas_num'], $contratoData['Contrato']['divisa']);*/

        // Fin Diego Enrique Sanchez

        //RYM Dias noches USA
        switch ($contratoData->noches) {
            case 4:
                $emailVars['dias_noches_usa_str'] = '4 (four) nights and 5 (five) days';
                break;
            default:
                $emailVars['dias_noches_usa_str'] = '2 (two) nights and 3 (three) days';
                break;
        }

        //RYM Dias noches USA v2
        switch ($contratoData->noches) {
            case 4:
                $emailVars['dias_noches_usa_str_v2'] = 'Four (4) Nights';
                break;
            default:
                $emailVars['dias_noches_usa_str_v2'] = 'Two (2) Nights';
                break;
        }

        //RYM Numero de noches
        $emailVars['rym_noches'] = $contratoData->noches;

        return $emailVars;
    }

}
