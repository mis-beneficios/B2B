<?php
namespace App\Payment;

use App\User;

// use Openpay\Client as Openpay;


// use Openpay\Data\Client as Openpay;
// require_once base_path('vendor/autoload.php');
use Openpay\Data\Openpay;

require_once base_path('vendor/autoload.php');

class OpenpayPayment
{

    public $id, $sk, $pk;
    public function __construct()
    {
        $this->id = env('OPENPAY_ID');
        $this->sk = env('OPENPAY_SK');
        $this->pk = env('OPENPAY_PK');
        
        Openpay::setId($this->id);
        Openpay::setApiKey($this->sk);

        // env('OPENPAY_PRODUCTION_MODE')
        // env('OPENPAY_ENVIROMENT')
    }

    /**
     * Realizar Cargon con token por tarjeta (openpay.js).
     * Autor    Diego Enrique Sanchez
     * Creado   2023-01-08
     * @param  \Illuminate\Http\Request  $data
     * @return \Illuminate\Http\Response
     */
    public function create_checkout_token_card($data, $payment_id = null)
    {

        try {
            // Desarrollo
            // $openpay = Openpay::getInstance('mg5gbhhc1ccudrhgp6v8', 'sk_5935c362ea06474dbc149ff4987e109a');
            
            //Produccion 
            $openpay = Openpay::getInstance($this->id, $this->sk);

            $customer = array(
                'name'             => $data['user']['nombre'],
                'last_name'        => $data['user']['apellidos'],
                'email'            => $data['user']['email'],
                'requires_account' => false,
                'phone_number'     => $data['user']['telefono'],
            );

            $chargeRequest = array(
                'method'            => 'card',
                'source_id'         => $data['token_id'],
                'amount'            => $data['amount'],
                'currency'          => 'MXN',
                'description'       => $data['description'],
                // 'order_id'          => 'oid-00052',
                'device_session_id' => $data['device_session_id'],
                'customer'          => $customer,
            );

            $response['success'] = true;
            $response['cargo']   = $openpay->charges->create($chargeRequest);
            // dd($response);
            return $response;

        } catch (\OpenpayApiTransactionError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (\OpenpayApiRequestError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (\OpenpayApiConnectionError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (\OpenpayApiAuthError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (\OpenpayApiError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        }
    }

    /**
     * Creacion de tarjeta para obtener el source_id y procesar los pagos seleccionando el metodo de pago
     * Autor:   Isw. Diego Enrique Sanchez
     * Creado   2023-01-10
     * @param [array] $data
     * @return $source_id
     */
    public function create_source($data)
    {
        $openpay = Openpay::getInstance($this->id, $this->sk);
        try {
            $user       = User::findOrFail($data->user_id);
            $valid_user = $this->validarUser($user);

            $vence = explode('/', $data->vencimiento);

            $cardDataRequest = array(
                'holder_name'      => $data->titular,
                'card_number'      => str_replace('-', '', $data->numero_tarjeta),
                'cvv2'             => $data->cvv,
                'expiration_month' => $vence[0],
                'expiration_year'  => $vence[1],
            );

            $customer = $openpay->customers->get($valid_user);

            $response['success']   = true;
            $response['source_id'] = $customer->cards->add($cardDataRequest);

            return $response;
        } catch (OpenpayApiTransactionError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (OpenpayApiRequestError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (OpenpayApiConnectionError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (OpenpayApiAuthError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (OpenpayApiError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (\Exception $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        }

        // return $cardDataRequest;
    }

    /**
     * Valida el usuario, en caso de no existir crea uno nuevo en openpay y asociamos el id al user amando a mexico.
     * Autor    Diego Enrique Sanchez
     * Creado   2023-01-10
     * @param  $data
     * @return $id_customer
     */
    public function createUser($auth)
    {

        // Desarrollo
        // $openpay = Openpay::getInstance('mg5gbhhc1ccudrhgp6v8', 'sk_5935c362ea06474dbc149ff4987e109a');
        
        //Produccion 
       $openpay = Openpay::getInstance($this->id, $this->sk);

        $user = User::where('username', $auth->username)->first();

        if ($user->payment_id != null) {
            $id_customer = $user->payment_id;
        } else {
            $customerData = array(
                'external_id'      => $auth->id,
                'name'             => $auth->nombre,
                'last_name'        => $auth->apellidos,
                'email'            => $auth->username,
                'requires_account' => false,
                'phone_number'     => $auth->telefono,
            );

            $customer = $openpay->customers->add($customerData);

            $user->payment_id = $customer->id;
            $user->save();

            $id_customer = $customer->id;
        }

        return $id_customer;
    }

    /**
     * Valida el usuario, en caso de no existir crea uno nuevo en openpay y asociamos el id al user amando a mexico.
     * Autor    Diego Enrique Sanchez
     * Creado   2023-01-10
     * @param  $data
     * @return $id_customer
     */
    public function validarUser($auth)
    {

        // Desarrollo
        // $openpay = Openpay::getInstance('mg5gbhhc1ccudrhgp6v8', 'sk_5935c362ea06474dbc149ff4987e109a');
        
        //Produccion 
       $openpay = Openpay::getInstance($this->id, $this->sk);
        $user    = User::where('username', $auth->username)->first();

        if ($user->payment_id != null) {
            $id_customer = $user->payment_id;
        } else {
            $customerData = array(
                'external_id'      => $auth->id,
                'name'             => $auth->nombre,
                'last_name'        => $auth->apellidos,
                'email'            => $auth->username,
                'requires_account' => false,
                'phone_number'     => $auth->telefono,
            );

            $customer = $openpay->customers->add($customerData);

            $user->payment_id = $customer->id;
            $user->save();

            $id_customer = $customer->id;
        }

        return $id_customer;
    }

    /**
     * Consultar cargo realizado por id.
     * Autor    Diego Enrique Sanchez
     * Creado   2023-01-10
     * @param   $id
     * @return objeto openpay: cargo
     */
    public function getOrder($id)
    {
        // Desarrollo
        // $openpay = Openpay::getInstance('mg5gbhhc1ccudrhgp6v8', 'sk_5935c362ea06474dbc149ff4987e109a');
        
        //Produccion 
      $openpay = Openpay::getInstance($this->id, $this->sk);
        return $openpay->charges->get($id);
    }

    /**
     * Autor:    Diego Enrique Sanchez
     * Creado    2023-01-10
     * Accion:   Creacion de cargo mediante pago en efectivo
     * @param    $cantidad
     * @return   objeto cargo
     */
    public function checkoutPaymentCash($data)
    {
        try {
            $contrato = Contrato::findOrFail($data->contrato_id);

            $date       = Carbon::now();
            $expires_at = $date->add(5, 'day')->toAtomString();

            // Desarrollo
            // $openpay = Openpay::getInstance('mg5gbhhc1ccudrhgp6v8', 'sk_5935c362ea06474dbc149ff4987e109a');
            
            //Produccion 
          $openpay = Openpay::getInstance($this->id, $this->sk);

            $chargeData = array(
                'method'      => 'store',
                'amount'      => intval($data->cantidad),
                'description' => "Abono a paquete " . $contrato->paquete->Titulo,
                'due_date'    => $expires_at,
                'customer'    => [
                    'name'         => Auth::user()->nombre,
                    'last_name'    => (Auth::user()->apellido_materno) ? Auth::user()->apellido_paterno . ' ' . Auth::user()->apellido_materno : Auth::user()->apellido_paterno,
                    'phone_number' => Auth::user()->telefono,
                    'email'        => Auth::user()->email,
                ],
            );

            $response['success'] = true;
            $response['cargo']   = $openpay->charges->create($chargeData);
            return $response;

        } catch (OpenpayApiTransactionError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (OpenpayApiRequestError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (OpenpayApiConnectionError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (OpenpayApiAuthError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (OpenpayApiError $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        } catch (Exception $e) {
            $response['success'] = false;
            $response['errors']  = [
                'category'    => $e->getCategory(),
                'error_code'  => $e->getErrorCode(),
                'description' => $e->getMessage(),
                'http_code'   => $e->getHttpCode(),
                'request_id'  => $e->getRequestId(),
            ];

            return $response;
        }

    }

    public function prueba_token($data)
    {
        // Desarrollo
        // $openpay = Openpay::getInstance('mg5gbhhc1ccudrhgp6v8', 'sk_5935c362ea06474dbc149ff4987e109a');
        
        //Produccion 
       $openpay = Openpay::getInstance($this->id, $this->sk);
        $customer = array(
            'name'         => 'Frander Jairo',
            'last_name'    => 'Ordonez',
            'phone_number' => '7131159863',
            'email'        => 'diego.enrique1907@gmail.com');

        $chargeRequest = array(
            'method'            => 'card',
            'source_id'         => 'klaaew9qv79wugefqixl',
            'amount'            => 101.01,
            'currency'          => 'MXN',
            'description'       => 'Cargo inicial a mi merchant',
            // 'order_id'          => 'oid-1000',
            'device_session_id' => $data['device_session_id'],
            'customer'          => $customer,
        );

        $charge = $openpay->charges->create($chargeRequest);
        return $charge;

    }

    public function errores($error_code)
    {
        switch ($error_code) {
            case '1000':
                $error_message = 'Ocurrió un error interno en el servidor de Openpay';
                break;
            /**/case '1001':
              /**/  $error_message = 'El formato de la petición no es JSON, los campos no tienen el formato correcto, o la petición no tiene campos que son requeridos.';
                /**/break;
            case '1002':
                $error_message = 'La llamada no esta autenticada o la autenticación es incorrecta.';
                break;
            case '1003':
                $error_message = 'La operación no se pudo completar por que el valor de uno o más de los parámetros no es correcto.';
                break;
            case '1004':
                $error_message = 'Un servicio necesario para el procesamiento de la transacción no se encuentra disponible.';
                break;
            case '1005':
                $error_message = 'Uno de los recursos requeridos no existe.';
                break;
            case '1006':
                $error_message = 'Ya existe una transacción con el mismo ID de orden.';
                break;
            case '1007':
                $error_message = 'La transferencia de fondos entre una cuenta de banco o tarjeta y la cuenta de Openpay no fue aceptada.';
                break;
            case '1008':
                $error_message = 'Una de las cuentas requeridas en la petición se encuentra desactivada.';
                break;
            case '1009':
                $error_message = 'El cuerpo de la petición es demasiado grande.';
                break;
            case '1010':
                $error_message = 'Se esta utilizando la llave pública para hacer una llamada que requiere la llave privada, o bien, se esta usando la llave privada desde JavaScript.';
                break;
            case '1011':
                $error_message = 'Se solicita un recurso que esta marcado como eliminado.';
                break;
            case '1012':
                $error_message = 'El monto transacción esta fuera de los limites permitidos.';
                break;
            case '1013':
                $error_message = 'La operación no esta permitida para el recurso.';
                break;
            case '1014':
                $error_message = 'La cuenta esta inactiva.';
                break;
            case '1015':
                $error_message = 'No se ha obtenido respuesta de la solicitud realizada al servicio.';
                break;
            case '1016':
                $error_message = 'El mail del comercio ya ha sido procesada.';
                break;
            case '1017':
                $error_message = 'El gateway no se encuentra disponible en ese momento.';
                break;
            case '1018':
                $error_message = 'El número de intentos de cargo es mayor al permitido.';
                break;
            case '1020':
                $error_message = 'El número de dígitos decimales es inválido para esta moneda.';
                break;
            case '1023':
                $error_message = 'Se han terminado las transacciones incluidas en tu paquete. Para contratar otro paquete contacta a soporte@openpay.mx.';
                break;
            case '1024':
                $error_message = 'El monto de la transacción excede su límite de transacciones permitido por TPV';
                break;
            case '1025':
                $error_message = 'Se han bloqueado las transacciones CoDi contratadas en tu plan';
                break;
            case '2001':
                $error_message = 'La cuenta de banco con esta CLABE ya se encuentra registrada en el cliente.';
                break;
            case '2003':
                $error_message = 'El cliente con este identificador externo (External ID) ya existe.';
                break;
            case '2004':
                $error_message = 'El número de tarjeta es invalido.';
                break;
            case '2005':
                $error_message = 'La fecha de expiración de la tarjeta es anterior a la fecha actual.';
                break;
            case '2006':
                $error_message = 'El código de seguridad de la tarjeta (CVV2) no fue proporcionado.';
                break;
            case '2007':
                $error_message = 'El número de tarjeta es de prueba, solamente puede usarse en Sandbox.';
                break;
            case '2008':
                $error_message = 'La tarjeta no es valida para pago con puntos.';
                break;
            case '2009':
                $error_message = 'El código de seguridad de la tarjeta (CVV2) es inválido';
                break;
            case '2010':
                $error_message = 'Autenticación 3D Secure fallida.';
                break;
            case '2011':
                $error_message = 'Tipo de tarjeta no soportada.';
                break;
            case '3001':
                $error_message = 'La tarjeta fue declinada por el banco.';
                break;
            case '3002':
                $error_message = 'La tarjeta ha expirado.';
                break;
            case '3003':
                $error_message = 'La tarjeta no tiene fondos suficientes.';
                break;
            case '3004':
                $error_message = 'Comprobar metodo de pago';
                // $error_message = 'La tarjeta ha sido identificada como una tarjeta robada.';
                break;
            case '3005':
            case '1001':
                $error_message = 'Comprobar metodo de pago';
                // $error_message = 'La tarjeta ha sido rechazada por el sistema antifraude.';
                break;
            case '3006':
                $error_message = 'La operación no esta permitida para este cliente o esta transacción.';
                break; 
            case '3009':
                $error_message = 'La tarjeta fue reportada como perdida.';
                break;
            case '3010':
                $error_message = 'El banco ha restringido la tarjeta.';
                break;
            case '3011':
                $error_message = 'El banco ha solicitado que la tarjeta sea retenida. Contacte al banco.';
                break;
            case '3012':
                $error_message = 'Se requiere solicitar al banco autorización para realizar este pago.';
                break;
            case '3201':
                $error_message = 'Comercio no autorizado para procesar pago a meses sin intereses.';
                break;
            case '3203':
                $error_message = 'Promoción no valida para este tipo de tarjetas.';
                break;
            case '3204':
                $error_message = 'El monto de la transacción es menor al mínimo permitido para la promoción.';
                break;
            case '3205':
                $error_message = 'Promoción no permitida.';
                break;
            default:
                $error_message = 'Comprobar metodo de pago';

                break;
        }

        return $error_message;
    }

}
