<?php

namespace App\Mail\Usa;

use App\AlertaUsa as SendAlerta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlertaUsa extends Mailable
{
    use Queueable, SerializesModels;

    public $alerta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SendAlerta $alerta)
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

        // if (env('APP_ID') == 'usoptucorp') {
        $username = 'My Travel Benefits';
        $from     = 'mailer@optucorp.com';
        // } else {
        //     $username = env('APP_NAME');
        //     $from     = env('MAIL_FROM_ADDRESS');
        // }

        $cc_ = array('renemoyo@optucorp.com', 'dsanchez@pacifictravels.mx');

        return $this->from($from, $username)
            ->subject('Alerta pre-registro Optucorp')
            ->bcc($cc_)
            ->view('mails.usa.alerta_usa');
    }
}
