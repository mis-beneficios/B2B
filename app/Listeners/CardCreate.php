<?php

namespace App\Listeners;

use App\Events\CreateCard;
use App\Tarjeta;
use Carbon\Carbon;

class CardCreate
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  CreateCard  $event
     * @return void
     */
    public function handle(CreateCard $event)
    {
        $fecha = Carbon::now();
        if (isset($event->tarjeta['vencimiento'])) {
            $vence = explode('/', $event->tarjeta['vencimiento']);
            $mes   = $vence[0];
            $anio  = '20' . $vence[1];
        } else {
            $mes  = $event->tarjeta['expiration_month'];
            $anio = '20' . $event->tarjeta['expiration_year'];
        }

        $tarjeta                       = new Tarjeta;
        $tarjeta->user_id              = $event->user;
        $tarjeta->banco_id             = $event->tarjeta['banco'];
        $tarjeta->name                 = $event->tarjeta['titular'];
        $tarjeta->banco                = $event->tarjeta['red_bancaria'];
        $tarjeta->numero               = str_replace('-', '', $event->tarjeta['numero_tarjeta']);
        $tarjeta->tipo                 = $event->tarjeta['tipo'];
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
