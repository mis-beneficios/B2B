<?php

namespace App\Listeners;

use App\Events\CreateUser;
use App\User;
use Auth;
use Carbon\Carbon;

class UserCreate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreateUser  $event
     * @return void
     */
    public function handle(CreateUser $event)
    {

        $fecha             = Carbon::now();
        $user              = new User;
        $user->convenio_id = $event->user['convenio_id'];
        $user->padre_id    = env('PADRE_ID', 146);
        $user->username    = $event->user['username'];
        $user->password    = $event->user['password'];
        $user->pass_hash   = $event->user['pass_hash'];
        $user->role        = 'client';
        $user->manager     = 0;
        $user->created     = $fecha;
        $user->modified    = $fecha;
        $user->nombre      = $event->user['nombre'];
        $user->apellidos   = $event->user['apellidos'];

        if ($event->user['direccion']) {
            $user->direccion     = $event->user['direccion'];
            $user->ciudad        = (isset($event->user['delegacion'])) ? $event->user['delegacion'] : $event->user['ciudad'];
            $user->provincia     = $event->user['estado'];
            $user->pais          = env('APP_PAIS_ID');
            $user->codigo_postal = $event->user['cp'];
        }

        $user->telefono   = $event->user['telefono'];
        $user->clave      = $event->user['clave'];
        $user->confirmado = 0;

        $user->permitir_login = 1;
        $user->entrada_1      = '08:30:00';
        $user->entrada_2      = '15:00:00';
        $user->salida_1       = '15:00:00';
        $user->salida_2       = '18:30:00';
        $user->lu             = 1;
        $user->ma             = 1;
        $user->mi             = 1;
        $user->ju             = 1;
        $user->vi             = 1;
        $user->sa             = 1;
        $user->do             = 1;

        $user->como_se_entero    = (isset($event->user['como_se_entero'])) ? $event->user['como_se_entero'] : 3;
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

        /*
        Sistema por el cual se registro el usuario
         */
        $user->system_register = 'mbv';

        $user->save();
        Auth::loginUsingId($user->id);

        return $user;
    }
}
