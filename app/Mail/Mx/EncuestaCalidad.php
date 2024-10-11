<?php

namespace App\Mail\Mx;

use App\Encuesta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EncuestaCalidad extends Mailable
{
    use Queueable, SerializesModels;

    public $encuesta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Encuesta $encuesta)
    {
        $this->encuesta = $encuesta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Encuesta de satisfaccion ' . $encuesta->nombre . ' ' . $encuesta->apellidos)
            // ->bcc('dsanchez@pacifictravels.mx')
            ->view('mails.mx.encuesta_calidad');
    }
}
