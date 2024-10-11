<?php
namespace App\Traits;

use App;
use Illuminate\Support\Facades\Http;
use App\Incidencia;
use Auth;
use Carbon\Carbon;


trait BeneficiosTrait
{
    public function store_incidencia()
    {
        
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        // Ejemplo de detección de navegador
        if (strpos($userAgent, 'Chrome') !== false) {
            $navegador = "Google Chrome";
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $navegador = "Mozilla Firefox";
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $navegador = "Safari";
        } elseif (strpos($userAgent, 'Opera') !== false) {
            $navegador = "Opera";
        } else {
            $navegador = "Estás utilizando un navegador desconocido";
        }

        $ipAddress = $_SERVER['REMOTE_ADDR'];

        $login = new Incidencia;

        $login->user_id     = Auth::user()->id;
        $login->caso        = 'Inicio de sesión';
        $login->descripcion = 'Navegador '. $navegador . ' <br> ' . $userAgent . '<br> Ip: '. $ipAddress;
        $login->estatus     = 'nuevo';
        $login->clase       = 'login';
        $login->created     = Carbon::now();
        $login->created_at  = Carbon::now();

        if ($login->save()) {
            return $login;
        }
        return false;
    }
}
