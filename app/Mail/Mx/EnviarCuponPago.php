<?php

namespace App\Mail\Mx;

use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarCuponPago extends Mailable
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
        // dd($this->data);
        $subject = $this->data['asunto'];

        $cupon_send = $this->from($this->data['de'], (Auth::user()->config) ? Auth::user()->config->from_name : env('MAIL_FROM_NAME'))
        // $cupon_send = $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($subject)
            ->view('mails.mx.enviar_cupon_pago')
            // ->bcc('dsanchez@pacifictravels.mx')
            // ->bcc('contratos@pacifictravels.mx')
            // ->bcc('mailer@beneficiosvacacionales.mx')
            ->attach($this->data['file'], [
                'as'   => $this->data['name'],
                'mime' => 'application/pdf',
            ])
            ->replyTo($this->data['de'], Auth::user()->fullName);

        return $cupon_send;
    }
}
