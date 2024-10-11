<?php

namespace App\Mail\Mx;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\IntentoCompra as IC;
use DB;
class IntentoCompra extends Mailable
{
    use Queueable, SerializesModels;

    public $compra;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(IC $compra)
    {
        $this->compra = $compra;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $estancias =  DB::select('SELECT * FROM estancias where solosistema = 0 and estancia_paise_id = 1 and temporada != "grupo" and title like "%2023" ORDER BY RAND() LIMIT 3');
        
        $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('¡Finaliza hoy tu compra y disfruta de este gran beneficios con Beneficios Vacacionales! ✈☀')
            ->view('mails.mx.intento_compra', compact('estancias'));

        return $this;
    }
}
