<?php

namespace App\Listeners;

use App\Events\CreateCardUsa;
use App\Tarjeta;
use Carbon\Carbon;

class CardCreateUsa
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
     * @param  CreateCardUsa  $event
     * @return void
     */
    public function handle(CreateCardUsa $event)
    {
        $fecha = Carbon::now();
        if (isset($event->tarjeta['expiration'])) {
            $vence = explode('/', $event->tarjeta['expiration']);
            $mes   = $vence[0];
            $anio  = '20' . $vence[1];
        }
        $tarjeta           = new Tarjeta;
        $tarjeta->user_id  = $event->user;
        $tarjeta->banco_id = 87;
        $tarjeta->name     = $event->tarjeta['holder_name'];
        $tarjeta->banco    = 'VISA';
        $tarjeta->numero   = str_replace('-', '', $event->tarjeta['card_number']);
        // $tarjeta->tipo                 = $event->tarjeta['tipo'];
        $tarjeta->mes                  = $mes;
        $tarjeta->ano                  = $anio;
        $tarjeta->cvv2                 = $event->tarjeta['cvv2'];
        $tarjeta->estatus              = 'Sin Verificar';
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
}
