<?php

namespace App\Mail\Mx;

use App\SorteoConvenio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarSorteo extends Mailable
{
    use Queueable, SerializesModels;

    public $sorteo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SorteoConvenio $sorteo)
    {
        $this->sorteo = $sorteo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from(env('MAIL_FROM_ADDRESS'), 'Beneficios Vacacionales')
            ->subject('Registro exitoso al sorteo Beneficios Vacacionales')
            ->view('mails.mx.enviar_sorteo');
            // ->bcc('contratos@pacifictravels.mx');
            // ->bcc('contratos@pacifictravels.mx')
            // ->bcc('mailer@beneficiosvacacionales.mx');
    }
}
