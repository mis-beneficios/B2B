<?php

namespace App\Observers;

use App\Mail\Mx\NuevaReservacion;
use App\Reservacion;
use Auth;
use Log;
use Mail;

class ReservacionObserver
{
    /**
     * Handle the reservacion "created" event.
     *
     * @param  \App\Reservacion  $reservacion
     * @return void
     */
    public function created(Reservacion $reservacion)
    {

        if (Auth::user()->role == 'client') {
            try {
                Mail::to('reservacionescorporativo@beneficiosvacacionales.mx')->send(new NuevaReservacion($reservacion));
                Log::notice('Notificacion de reservacion enviada a: reservacionescorporativo@beneficiosvacacionales.mx  con folio: ' . $reservacion->id);
            } catch (\Exception $e) {
                Log::error('No se pudo enviar la alerta de una nueva reservacion, reservacion con folio: ' . $reservacion->id);
            }
        } 
        // else {
        //     try {
        //         Mail::to('dsanchez@pacifictravels.mx')->send(new NuevaReservacion($reservacion));
        //         Log::notice('Notificacion de reservacion creada por reservaciones enviada a: dsanchez@pacifictravels.mx con folio: ' . $reservacion->id);
        //     } catch (\Exception $e) {
        //         Log::error('No se pudo enviar la alerta de una nueva reservacion, reservacion con folio: ' . $reservacion->id);
        //     }
        // }
    }

    /**
     * Handle the reservacion "updated" event.
     *
     * @param  \App\Reservacion  $reservacion
     * @return void
     */
    public function updated(Reservacion $reservacion)
    {
        //
    }

    /**
     * Handle the reservacion "deleted" event.
     *
     * @param  \App\Reservacion  $reservacion
     * @return void
     */
    public function deleted(Reservacion $reservacion)
    {
        //
    }

    /**
     * Handle the reservacion "restored" event.
     *
     * @param  \App\Reservacion  $reservacion
     * @return void
     */
    public function restored(Reservacion $reservacion)
    {
        //
    }

    /**
     * Handle the reservacion "force deleted" event.
     *
     * @param  \App\Reservacion  $reservacion
     * @return void
     */
    public function forceDeleted(Reservacion $reservacion)
    {
        //
    }
}
