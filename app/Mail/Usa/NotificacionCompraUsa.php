<?php

namespace App\Mail\Usa;

use App\Contrato;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacionCompraUsa extends Mailable
{
    use Queueable, SerializesModels;

    public $contrato;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contrato $contrato)
    {
        $this->contrato = $contrato;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $title = env('APP_NAME_USA');
        $from  = 'mailer@optucorp.com';

        $cc_ = array('renemoyo@optucorp.com');

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Alerta de compra ' . $this->contrato->paquete)
            ->bcc($cc_)
            ->view('mails.usa.alerta_compra_usa');
    }
}
