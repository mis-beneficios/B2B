<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecordatorioReservaciones extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        return $this->from(env('MAIL_FROM_ADDRESS'), config('app.app_name'))
            ->subject('Filtrado de pagos a hoteles pendientes')
            // ->bcc('dsanchez@beneficiosvacacionales.mx')
            ->view('mails.mx.recordatorio_reservaciones');
    }
}
