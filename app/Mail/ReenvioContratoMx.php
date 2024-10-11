<?php

namespace App\Mail;

use App\Contrato;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Storage;


class ReenvioContratoMx extends Mailable
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
        // try {
        $reenvio = $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject(config('app.app_name'). ', reenvio de contrato con folio: ' . $this->contrato->id)
            ->view('mails.reenvio_correo_mx')
            // ->bcc('contratos@pacifictravels.mx')
            ->bcc('contratos@pacifictravels.mx')
            // ->bcc('mailer@beneficiosvacacionales.mx')
            ->attach(public_path() . '/files/contratos_mx/' . 'C' . $this->contrato->id . '.pdf', [
                'as'   => 'C' . $this->contrato->id . '.pdf',
                'mime' => 'application/pdf',
            ]);

        // } catch (\Exception $e) {
        //     $reenvio = false;
        // }

        return $reenvio;
    }
}
