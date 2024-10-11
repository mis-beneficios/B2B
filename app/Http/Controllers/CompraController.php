<?php

namespace App\Http\Controllers;

use App;
// use GuzzleHttp\Psr7\Request;
use App\Contrato;
use App\Convenio;
use App\Estancia;
use App\Events\CreateUser;
use App\Helpers\ComisionesHelper;
use App\Helpers\ContratoPDFHelper;
use App\Helpers\PagosHelper;
use App\Http\Controllers\Controller;
use App\IntentoCompra;
use App\Mail\Mx\EnviarContrato;
use App\Mail\NotificacionNuevoRegistro;
use App\Mail\RegistroCliente;
use App\Payment\OpenpayPayment;
use App\Tarjeta;
use App\Traits\PaginaMx;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;
use Mail;
use Session;
use App\Banco;
use Stripe;
use App\Mail\Mx\Payment\SuccessAlert;

class CompraController extends Controller
{

    use PaginaMx;

    protected $session;
    // public $con;
    protected $payment;

    //Pagos quincenales
    public $pagos_por_contrato = 36;
    public $manejador_de_fecha;
    protected $comisiones;
    protected $pagos;

    public function __construct()
    {
        $this->session      = session()->get('activo');
        // $con                = new Contrato;
        $this->comisiones   = new ComisionesHelper;
        $this->pagos        = new PagosHelper;
        $this->contrato_pdf = new ContratoPDFHelper;

        $this->payment = new OpenpayPayment;

        $this->middleware('auth')->only('finalizar_compra');
    }

    public function validar_form(Request $request, $id = null)
    {
        $validator = \Validator::make($request->all(), [
            'nombre'    => (!Auth::check()) ? 'required | string | max:40' : '',
            'apellidos' => (!Auth::check()) ? 'required | string | max:40' : '',
            'username'  => (!Auth::check()) ? 'required | email  | unique:users' : '',
            'password'  => (!Auth::check()) ? 'required | string | min:8 | confirmed' : '',
            'direccion' => (!Auth::check()) ? 'required | string | max:255' : '',
            'telefono'  => (!Auth::check()) ? 'required | numeric | min:10' : '',
            'colonia'   => (!Auth::check()) ? 'required' : '',
            'cp'        => (!Auth::check()) ? 'required' : '',
        ]);
        // $validator = \Validator::make($request->all(), [
        //     'nombre'    => 'required | string | max:40',
        //     'apellidos' => 'required | string | max:40',
        //     'username'  => 'required | email  | unique:users',
        //     'password'  => 'required | string | min:8 | confirmed',
        //     'direccion' => 'required | string | max:255',
        //     'telefono'  => 'required | numeric | min:10',
        //     'colonia'   => 'required',
        //     'cp'        => 'required',
        // ]);
        return $validator;
    }

    public function validar_form_card(Request $request, $id = null)
    {

        // $validator = \Validator::make($request->all(), [
        //     'titular'          => 'required | string | max:40',
        //     'numero_tarjeta'   => 'required | string | max:19',
        //     'mes'              => 'required',
        //     'anio'             => 'required',
        //     'cvv2'             => 'required',
        //     'terminos'         => 'accepted',
        //     'primer_descuento' => 'required | date',
        //     // 'g-recaptcha-response' => 'required | captcha',
        // ]);

        $validator = \Validator::make($request->all(), [
            'titular'          =>  'required | string | max:40',
            'numero_tarjeta'   =>  'required | string | max:19',
            'mes'              =>  'required',
            'anio'             =>  'required',
            'cvv2'             =>  'required',
            'terminos'         => 'accepted',
            'primer_descuento' => 'required',
            'g-recaptcha-response' => 'required | captcha',
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
        // dd($request->all());
        $user = array();
        if ($request->fechas) {
            $fecha_request = explode(' al ', $request->fechas);
            $entrada = $fecha_request[0];
            $salida = $fecha_request[1];
        }


        $validate = $this->validar_form($request);
        if ($validate->fails()) {
            $username = User::whereUsername($request->username)->first() == null ? false : true;
            return response()->json(['success' => false, 'errors' => $validate->errors(), 'username' => $username]);
        }

        $estancia    = Estancia::findOrFail($request->estancia_id);
        $convenio_id = empty($estancia->convenio->id) ? 1208 : $estancia->convenio->id;

        $user['estancia_id'] = $request->estancia_id;
        $user['convenio_id'] = (session('convenio_id')) ? session('convenio_id') : $convenio_id;
        
        try {
            
            if ($request->fechas) {
                $user['fecha_viaje'] = $entrada; 
                $user['fecha_viaje_salida'] = $salida; 
            }
            
            $user['nombre']          = $request->nombre;
            $user['apellidos']       = $request->apellidos;
            $user['telefono']        = $request->telefono;
            $user['username']        = $request->username;
            $user['password']        = bcrypt($request->password);
            $user['clave']           = base64_encode($request->password);
            $user['pass_hash']       = bcrypt($request->password);
            $user['cp']              = $request->cp;
            $user['estado']          = $request->estado;
            $user['ciudad']          = $request->colonia;
            $user['provincia']       = $request->delegacion;
            $user['direccion']       = $request->direccion;
            $user['estancia_id']     = $request->estancia_id;
            $user['convenio_id']     = (session('convenio_id')) ? session('convenio_id') : $convenio_id;
            $user['system_register'] = config('app.empresa');
            

            
            if (!Auth::check()) {

                /**
                 * Lanzamos el evento para crear el usuario dentro de la base
                 */
                $auth = event(new CreateUser($user));
                if ($auth) {
                    $user_id      = $auth[0]['id'];
                    $username     = $auth[0]['username'];
                    $data['auth'] = Auth::loginUsingId($user_id);
                    try {
                        /**
                         * Se envia el correo de nuevo registro al cliente
                         */
                        Mail::to($username)->send(new RegistroCliente($auth[0]));
                    } catch (\Exception $e) {
                        Log::warning('No se pudo enviar el correo de bienvenida al cliente: ' . Auth::user()->username);
                    }

                }
            }
            /**
             * Creacion del usuario dentro de la pasarela para generar el "payment_id" y procesar los pagos en su panel o directo del panel administrativo
             */
            // $this->payment->createUser(Auth::user());

            /**
             * Creamos el registro del intento de compra para mandar makerting y culminar la compra
             */
            $intento_compra     = $this->intento_de_compra(Auth::user(), $user);
            $user['intento_id'] = $intento_compra;
            $data['card']       = route('metodo_pago');
            $data['success']    = true;

            Session::put('user', $user);
        } catch (\Exception $e) {
            $data['success']    = false;
            $data['exceptions'] = $e->getMessage();
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

        $validate = $this->validar_form_card($request);
        if ($validate->fails()) {
            $data['success'] = false;
            $data['errors']  = $validate->errors();
        } else {
            $data['token_create'] = true;
            $data['request']      = $request->all();
        }

        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_stripe(Request $request)
    {

        $user = session('user');

        $estancia_id = $user['estancia_id'];
        $estancia = Estancia::findOrFail($estancia_id);
        
        $data['tarjeta_id'] = null;
        
        $validate = $this->validar_form_card($request);
        
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $data['payment'] = Stripe\Charge::create ([
                "amount" => intval($estancia->enganche_especial * 100),
                "currency" => $estancia->divisa,
                "source" => $request->token_id,
                "description" => "This is test payment",
                'receipt_email' => Auth::user()->username,
        ]);


        dd($data['payment']);
    }

    public function create_order_checkout(Request $request)
    {
        $data['success'] = false;

        $user        = session('user');
        $estancia_id = $user['estancia_id'];
        $intento_id  = $user['intento_id']['id'];

        // dd($request->all(), $user);

        $estancia = Estancia::findOrFail($estancia_id);

        /**
         * Datos de usuario a realizar el cargo
         * se pasan a la pasarela como customer para enlazar el cargo
         */
        $data['user']['nombre']    = Auth::user()->nombre;
        $data['user']['apellidos'] = Auth::user()->apellidos;
        $data['user']['telefono']  = Auth::user()->telefono;
        $data['user']['email']     = Auth::user()->username;

        /**
         * Datos de la tarjeta capturados en el formulario de metodo de pago
         */
        $data['tarjeta']['holder_name']      = $request->titular;
        $data['tarjeta']['card_number']      = $request->numero_tarjeta;
        $data['tarjeta']['expiration_month'] = $request->mes;
        $data['tarjeta']['expiration_year']  = $request->anio;
        $data['tarjeta']['cvv2']             = $request->cvv2;
        $data['token_id']                    = $request->token_id;
        $data['device_session_id']           = $request->device_session_id;
        $data['amount']                      = $estancia->enganche_especial;
        $data['description']                 = 'Pago inicial Beneficios Vacacionales';

        // $cargo = $this->payment->prueba_token($data);
        // dd($cargo);
        /**
         * Creacion de la transaccion mediante el token de la tarjeta ingresada
         */
        $res = $this->payment->create_checkout_token_card($data, Auth::user()->payment_id);



        if ($res['success'] == false) {
            $data['errors']        = $res['errors'];
            $data['error_message'] = $this->payment->errores($res['errors']['error_code']);
        }

        if ($res['success'] == true && $res['cargo']->status == 'completed') {
            
            /*
             * Enviamos el correo de pago exitoso en caso de haberse procesado correctamente
             */
            try {
                $data['autorizacion'] = $res['cargo']->authorization;
                Mail::to(Auth::user()->username)->send(new SuccessAlert($data));
            } catch (\Exception $e) {
                Log::error('No se pudo enviar el mail de pago: ' . Auth::user()->username);
            }

            // dd($res);

            //Se proceso correctamente el cargo
            $data['tarjeta']['type']      = $res['cargo']->card->type;
            $data['tarjeta']['brand']     = $res['cargo']->card->brand;
            $data['tarjeta']['bank_name'] = $res['cargo']->card->bank_name;
            $data['tarjeta']['bank_code'] = $res['cargo']->card->bank_code;
            $data['tarjeta']['token_id']  = $request->token_id;


            // dd($data);
            /**
             * Validamos que la tarjeta ingresada exista; si existe se regresa el objeto para obtener el id
             * Caso contrario de crea un nuevo registro de la tarjeta
             */
            if ($this->validar_tarjeta_cliente($data['tarjeta'])) {
                $tarjeta = $this->validar_tarjeta_cliente($data['tarjeta']);
            } else {
                /**
                 * Registramos la tarjeta en la base de datos
                 */
                $tarjeta = $this->crear_tarjeta($data['tarjeta']);
            }

            /**
             * Generacion del contrato
             */
            $contrato = $this->generar_contrato($estancia->id, Auth::user()->id, $tarjeta->id, $user);
            if ($contrato) {
                /**
                 * Si se proceso el pago generamos el segmento 0 de enganche del contrato asociado
                 */

                $estatus = ($res['cargo']->status == 'completed') ? 'Pagado' : 'Rechazado';
                
                $this->pagos->cobro_pago_engache($contrato, $estatus);

                /**
                 * Se generan los pagos asociados al contrato
                 */
                $pagos = $this->pagos->generar_pagos_quincenales($contrato->id, $request->primer_descuento);

                /**
                 * Generamos las comisiones correspondientes
                 */
                $comisiones = $this->comisiones->generar_comisiones($contrato->id);

                /**
                 * Actualizamos el registro de intentos de compra
                 * Si se finalizo la compra el estatus lo pasamos a 1 en caso contrario sirve para enviar marketing digital ofreciendo el producto hasta terminar el registro
                 */
                $this->actualizar_intento_compra($intento_id);

                try {
                    /**
                     * Enviamos la notificacion de un nuevo registro de compra en linea
                     */
                    Mail::to('dsanchez@pacifictravels.mx')->send(new NotificacionNuevoRegistro($contrato));

                    /**
                     * Se envia el contrato al cliente registrado
                     */
                    $contrato_pdf = $this->contrato_pdf->obtener_contrato_pdf_mx($contrato->id);
                    Mail::to(Auth::user()->username)->send(new EnviarContrato($contrato));
                } catch (\Exception $e) {
                    Log::error('No se pudo enviar el pdf del contrato: ' . $contrato->id);
                }

                $data['url']     = route('finalizar_compra', $contrato->id);
                $data['success'] = true;

                $data['pagos']      = $pagos;
                $data['comisiones'] = $comisiones;

            }
        }

        return response()->json($data);
    }

    public function prueba_token()
    {
        $res = $this->payment->prueba_token();

        dd($res);
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-01-17
     * Actualizamos el intento de compra para comprobar si termino el registro
     * @param  [type] $intento_id
     */
    public function actualizar_intento_compra($intento_id)
    {
        IntentoCompra::where('id', $intento_id)
            ->update(['estatus' => 1]);
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

    /**
     * Autor: Isw Diego Sanchez Ordoñez
     * Creado: 2023-01-12
     * Se crea el contrato correspondiente asociada al usuario, estancia y tarjeta
     * @param  $estancia
     * @param  $user
     * @param  $tarjeta
     * @return $contrato
     */
    public function generar_contrato($estancia, $user, $tarjeta, $extra = null)
    {
        // dd($estancia, $user, $tarjeta, $user_s);
        $est     = Estancia::findOrFail($estancia);
        $cli     = User::findOrFail($user, ['id', 'username', 'convenio_id', 'nombre', 'apellidos']);
        $success = false;
        $info_estancia['house']  = false;

        if (isset($extra['fecha_viaje'])) {
            $fecha1 = Carbon::parse($extra['fecha_viaje']);
            $fecha2 = Carbon::parse($extra['fecha_viaje_salida']);
            $noches =  $fecha1->diffInDays($fecha2);
            $info_estancia['noches'] = $noches;
            $info_estancia['precio_house'] = $est->precio * $noches;
            $info_estancia['house']  = true;
        }


        $fecha   = Carbon::now();

        $contrato                                  = new Contrato;
        $contrato->user_id                         = $user;
        $contrato->convenio_id                     = (session('convenio_id')) ? session('convenio_id') : $cli->convenio_id;
        $contrato->estancia_id                     = $est->id;
        $contrato->tarjeta_id                      = $tarjeta;
        $contrato->paquete                         = $est->title;
        $contrato->estatus                         = 'comprado';
        $contrato->precio_de_compra                = ($info_estancia['house']) ? $info_estancia['precio_house']  : $est->precio;
        $contrato->pago_con_nomina                 = 0;
        $contrato->pago_con_otras_tarjetas         = 0;
        $contrato->estatus_de_pagos                = 0;
        $contrato->padre_id                        = env('PADRE_ID', 146);
        $contrato->noches                          = ($info_estancia['house']) ? $info_estancia['noches'] : $est->noches;
        $contrato->adultos                         = ($info_estancia['house']) ? 16 : $est->adultos;
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
        if ($info_estancia['house']) {
            $contrato->fecha_viaje = $fecha1->format('Y-m-d'); 
            $contrato->fecha_viaje_salida = $fecha2->format('Y-m-d'); 
        }

        if ($contrato->save()) {
            return $contrato;
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $response = Http::get('https://sistema.pacifictravels.mx/apirest/view/' . $password . '.json');
        if ($response->getBody()) {
            $res = json_decode($response->getBody(), true);
        }
        return $res;

    }

    public function metodo_de_pago()
    {

        $data     = session('user');
        $info_estancia['house']  = false;

        // dd($data);

        try {  
            // dd($data);
            $tarjetas = Tarjeta::where('user_id', Auth::user()->id)->get();
            $user     = Auth::user();
            $estancia = Estancia::findOrFail($data['estancia_id']);
            $bancos   = Banco::where('paise_id', 1)->get();


            if (isset($data['fecha_viaje'])) {
                $fecha1 = Carbon::parse($data['fecha_viaje']);
                $fecha2 = Carbon::parse($data['fecha_viaje_salida']);
                $noches =  $fecha1->diffInDays($fecha2);
                $info_estancia['noches'] = $noches;
                $info_estancia['precio_house'] = $estancia->precio * $noches;
                $info_estancia['house']  = true;
            }

            


            $datos = collect($info_estancia);
            // dd($tarjets, $user, $estancia);
            /*
                Vista para realziar el cargo mediente la pasarela de pago Openpay
                Por ahora deshabilitado hasta activar metodos de cargo directo en pasarela
            */
            // return view('pagina.mx.add_card', compact('user', 'estancia', 'tarjetas'));


            /*
                Vista para realizar el registro de la tarjeta sin cargo automatico en pasarela
                Vusta cambiante para pago con cargo directo
            */
            return view('pagina.mx.add_card', compact('user', 'estancia', 'tarjetas','bancos', 'datos'));
        } catch (\Exception $e) {
            return back();
        }


    }

    public function finalizar_compra($contrato_id)
    {
        $contrato = Contrato::findOrFail($contrato_id);
        return view('pagina.mx.finalizar_compra', compact('contrato'));
    }

    public function mostrar_contrato($id)
    {
        $contrato = Contrato::findOrFail($id);

        if ($contrato->estancia->estancia_paise_id == 7) {
            $res             = $this->contrato_pdf->mostrar_contrato($id);
            $data['formato'] = $res['formato'];
            $data['name']    = $res['name'];
            $data['success'] = true;

        } else if ($contrato->estancia->estancia_paise_id == 1 || $contrato->estancia->estancia_paise_id == 0) {
            $res             = $this->contrato_pdf->mostrar_contrato_mx($id);
            $data['formato'] = $res['formato'];
            $data['name']    = $res['name'];
            $data['success'] = true;
        } else {
            $data['success'] = false;
        }

        return response()->json($data);
    }

    public function descargar_contrato($id)
    {
        $con = Contrato::findOrFail($id);

        $contrato = $this->contrato_pdf->mostrar_contrato_mx($id);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($contrato['formato']);
        $pdf->download('Contrato-' . $con->id . '.pdf');
        return $pdf->stream('Contrato-' . $con->id . '.pdf');
    }

    public function obtener_contrato_pdf($con)
    {
        // $con      = Contrato::findOrFail($con);
        $contrato = $this->procesar_datos_contrato($con);
        $formato  = $this->construir_contrato($contrato, $con);

        $name = 'C' . $con->id . '.pdf';
        $path = public_path() . '/files/contratos_mx/' . $name;
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


       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_offline(Request $request)
    {

       $data['success'] = false;

       $user        = session('user');
       $estancia_id = $user['estancia_id'];
       $intento_id  = $user['intento_id'];


       $estancia = Estancia::findOrFail($estancia_id);

       /**
        * Datos de usuario a realizar el cargo
        * se pasan a la pasarela como customer para enlazar el cargo
        */
       $data['user']['nombre']    = Auth::user()->nombre;
       $data['user']['apellidos'] = Auth::user()->apellidos;
       $data['user']['telefono']  = Auth::user()->telefono;
       $data['user']['email']     = Auth::user()->username;

       /**
        * Datos de la tarjeta capturados en el formulario de metodo de pago
        */
       $data['tarjeta']['holder_name']      = $request->titular;
       $data['tarjeta']['card_number']      = $request->numero_tarjeta;
       $data['tarjeta']['expiration_month'] = $request->mes;
       $data['tarjeta']['expiration_year']  = $request->anio;
       $data['tarjeta']['cvv2']             = $request->cvv2;
       $data['tarjeta']['banco_id']         = $request->banco_id;
       $data['token_id']                    = $request->token_id;
       $data['device_session_id']           = $request->device_session_id;
       $data['amount']                      = $estancia->enganche_especial;
       $data['description']                 = 'Pago inicial Beneficios Vacacionales';


       /**
         * Validamos que la tarjeta ingresada exista; si existe se regresa el objeto para obtener el id
         * Caso contrario de crea un nuevo registro de la tarjeta
         */
        if ($this->validar_tarjeta_cliente($data['tarjeta'])) {
            $tarjeta = $this->validar_tarjeta_cliente($data['tarjeta']);
        } else {
            /**
             * Registramos la tarjeta en la base de datos
             */
            $tarjeta = $this->crear_tarjeta($data['tarjeta']);
        }

        /**
         * Generacion del contrato
         */
        $contrato = $this->generar_contrato($estancia->id, Auth::user()->id, $tarjeta->id, $user);
        if ($contrato) {
            /**
             * Si se proceso el pago generamos el segmento 0 de enganche del contrato asociado
             */

            $estatus = 'Por Pagar';
            $this->pagos->cobro_pago_engache($contrato, $estatus);

            /**
             * Se generan los pagos asociados al contrato
             */
            $pagos = $this->pagos->generar_pagos_quincenales($contrato->id, $request->primer_descuento);

            /**
             * Generamos las comisiones correspondientes
             */
            $comisiones = $this->comisiones->generar_comisiones($contrato->id);

            /**
             * Actualizamos el registro de intentos de compra
             * Si se finalizo la compra el estatus lo pasamos a 1 en caso contrario sirve para enviar marketing digital ofreciendo el producto hasta terminar el registro
             */
            $this->actualizar_intento_compra($intento_id);

            try {
                /**
                 * Enviamos la notificacion de un nuevo registro de compra en linea
                 */
                Mail::to('dsanchez@pacifictravels.mx')->send(new NotificacionNuevoRegistro($contrato));

                /**
                 * Se envia el contrato al cliente registrado
                 */
                $contrato_pdf = $this->contrato_pdf->obtener_contrato_pdf_mx($contrato->id);
                Mail::to(Auth::user()->username)->send(new EnviarContrato($contrato));
            } catch (\Exception $e) {
                Log::error('No se pudo enviar el pdf del contrato: ' . $contrato->id);
            }

            $data['url']     = route('finalizar_compra', $contrato->id);
            $data['success'] = true;

            $data['pagos']      = $pagos;
            $data['comisiones'] = $comisiones;

        }

        return response()->json($data);
    }


}

// public function create_order_checkout(Request $request)
// {
//     $data['success'] = false;
//     $validate        = $this->validar_form_card($request);
//     if ($validate->fails()) {
//         return response()->json(['success' => false, 'errors' => $validate->errors()]);
//     }
//     $user     = session('user');
//     $estancia = $user['estancia_id'];

//     if ($request->tarjeta_id) {
//         $tarjeta                = Tarjeta::findOrFail($request->tarjeta_id);
//         $mes                    = ($tarjeta->mes <= 9) ? '0' . $tarjeta->mes : $tarjeta->mes;
//         $tarjeta['expiration']  = $mes . '/' . substr($tarjeta->ano, 2);
//         $tarjeta['card_number'] = $tarjeta->numero;
//         $tarjeta['cvv2']        = $tarjeta->cvv2;
//         $tarjeta['auth']        = true;

//         if ($tarjeta->tipo == 'Debito') {
//             $tarjeta['type'] = 'DEBITCARD';
//         } else {
//             $tarjeta['type'] = 'CREDITCARD';
//         }
//     }

//     if (Auth::check()) {
//         if ($request->titular || $request->numero_tarjeta) {
//             $tarjeta    = event(new CreateCard($request, Auth::user()->id));
//             $tarjeta_id = $tarjeta[0]['id'];
//         } else {
//             $tarjeta_id = $request->tarjeta_id;
//         }

//         $user_id  = Auth::user()->id;
//         $username = Auth::user()->username;
//     } else {
//         $user     = event(new CreateUser(session('user')));
//         $user_id  = $user[0]['id'];
//         $username = $user[0]['username'];
//         Mail::to($username)->send(new RegistroCliente($user[0]));
//         $tarjeta    = event(new CreateCard($request, $user_id));
//         $tarjeta_id = $tarjeta[0]['id'];

//     }

//     $contrato = $this->generar_contrato($estancia, $user_id, $tarjeta_id);
//     if ($contrato) {
//         $pagos      = $this->pagos->generar_pagos_quincenales($contrato->id, $request->primer_descuento);
//         $comisiones = $this->comisiones->generar_comisiones($contrato->id);

//         Mail::to('dsanchez@pacifictravels.mx')->send(new NotificacionNuevoRegistro($contrato));

//         try {
//             $contrato_pdf = $this->contrato_pdf->obtener_contrato_pdf_mx($contrato->id);

//             Mail::to($username)->send(new EnviarContrato($contrato));
//         } catch (Exception $e) {
//             Log::error('No se pudo enviar el pdf del contrato: ' . $contrato->id);
//         }

//         $data['auth']    = Auth::loginUsingId($user_id);
//         $data['url']     = route('finalizar_compra', $contrato->id);
//         $data['success'] = true;

//         $data['pagos']      = $pagos;
//         $data['comisiones'] = $comisiones;

//     }

//     return response()->json($data);
// }

/**
 * Viejo metodo de accion
 */
// public function metodo_de_pago()
// {

//     if (Auth::check()) {
//         $tarjetas = Tarjeta::where('user_id', Auth::user()->id)->get();
//     } else {
//         $tarjetas = false;
//     }

//     if (Auth::check()) {
//         $user     = Auth::user();
//         $estancia = Estancia::findOrFail($user['estancia_id']);
//         $bancos   = Banco::where('paise_id', 1)->get();
//         return view('pagina.mx.add_card', compact('user', 'bancos', 'estancia', 'tarjetas'));
//     }

//     abort(419);
// }
