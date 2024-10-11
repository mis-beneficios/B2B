<?php

namespace App\Mail\Mx;

use App\Contrato;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarContrato extends Mailable
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
        $subject       = "Contrato de compra en " . config('app.app_name') . " #" . $this->contrato->id;
        $contrato_send = $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($subject)
            ->view('mails.mx.nueva_compra')
            ->bcc('contratos@pacifictravels.mx')
            ->bcc('mailer@beneficiosvacacionales.mx')
            ->attach(public_path() . '/files/contratos_mx/' . 'C' . $this->contrato->id . '.pdf', [
                'as'   => 'C' . $this->contrato->id . '.pdf',
                'mime' => 'application/pdf',
            ]);

        return $contrato_send;
    }
}
