<?php

namespace App\Mail\Mx;

use App\AlertaMx;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendAlertMx extends Mailable
{
    use Queueable, SerializesModels;

    public $alerta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AlertaMx $alerta)
    {
        $this->alerta = $alerta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $cc_ = array('renemoyo@optucorp.com', 'alertasmexico@pacifictravels.mx');
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Alerta intento de compra Mexico: ' . $this->alerta->empresa)
            ->bcc($cc_)
            ->view('mails.mx.alerta_mx');
    }
}
