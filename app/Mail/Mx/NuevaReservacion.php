<?php

namespace App\Mail\Mx;

use App\Reservacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NuevaReservacion extends Mailable
{
    use Queueable, SerializesModels;

    public $reservacion;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservacion $reservacion)
    {
        $this->reservacion = $reservacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            // ->bcc('dsanchez@pacifictravels.mx')
            ->subject('Nueva reservación del cliente: ' . $this->reservacion->cliente->fullName)
            ->view('mails.mx.nueva_reservacion');
    }
}
