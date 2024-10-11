<?php
/**
 *  Envio de notificacion por SMS en caso de fallas del sistema
 *  Autor: Isw. Diego Enrique Sanchez
 *  Creado: 2022-10-25
 */
namespace App\Helpers;

use Log;

class SmsHelper
{

    private $num = '';
    public function __construct()
    {
        $this->num = "00527131150285";
    }
    public function send_sms($mensaje)
    {

        if (env('APP_ENV') == 'production') {

            $url  = "https://api.netelip.com/v1/sms/api.php";
            $post = array(
                "token"       => "6a531d7f09d72b21cc11be29745efa1fd8fdc4113930430149bd70f474d6a22f",
                "from"        => "Benficios Vacacionales",
                "destination" => $this->num,
                "message"     => $mensaje,
            );

            $request = curl_init($url);
            curl_setopt($request, CURLOPT_POST, 1);
            curl_setopt($request, CURLOPT_POSTFIELDS, $post);
            curl_setopt($request, CURLOPT_TIMEOUT, 180);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($request);
            if ($response !== false) {
                $response_code = curl_getinfo($request, CURLINFO_HTTP_CODE);
                switch ($response_code) {
                    case 200:
                        Log::debug('Mensaje SMS enviado con exito por falla del sistema');
                        break;
                    default:
                        Log::critical('Error al enviar el mensaje SMS por falla del sistema');
                }
            } else {
                // Manejar error de conexión
            }
            curl_close($request);
        }
    }


    public function enviar_sms($numero, $mensaje)
    {
        try {
                
            $fullNumber = '0052'.$numero;
            // if (env('APP_ENV') == 'production') {

            $url  = "https://api.netelip.com/v1/sms/api.php";
            $post = array(
                "token"       => "6a531d7f09d72b21cc11be29745efa1fd8fdc4113930430149bd70f474d6a22f",
                "from"        => "Beneficios Vacacionales",
                "destination" => $fullNumber,
                "message"     => $mensaje,
            );

            $request = curl_init($url);
            curl_setopt($request, CURLOPT_POST, 1);
            curl_setopt($request, CURLOPT_POSTFIELDS, $post);
            curl_setopt($request, CURLOPT_TIMEOUT, 180);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($request);
            if ($response !== false) {
                $response_code = curl_getinfo($request, CURLINFO_HTTP_CODE);
                switch ($response_code) {
                    case 200:
                        Log::debug('Mensaje SMS enviado con exito!');
                        break;
                    default:
                        Log::critical('Error al enviar el mensaje SMS por falla del sistema');
                }
            } else {
                // Manejar error de conexión
            }
            curl_close($request);
            // }
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
        }
    }
}
