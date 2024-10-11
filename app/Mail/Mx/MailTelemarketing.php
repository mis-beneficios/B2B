<?php

namespace App\Mail\Mx;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailTelemarketing extends Mailable
{
    use Queueable, SerializesModels;

    public $estancias;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($estancias)
    {
        $this->estancias = $estancias;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $estancias = $this->estancias;

        $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('¡Es temporada de vacaciones, aprovecha los beneficios que tenemos para ti! ✈☀')
            ->view('mails.mx.mail_telemarketing', compact('estancias'));

        return $this;
    }
}
