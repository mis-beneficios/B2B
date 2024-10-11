<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPurchase extends Mailable
{
    use Queueable, SerializesModels;
    private $contrato;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contrato)
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
        return $this->from('mailer@optucorp.com', 'My Travel Benefits')
            ->subject('Buy new contract')
            ->view('mails.purchase_contrato')
            ->with([
                'cliente'            => $this->contrato->cliente->fullName,
                'contrato_id'        => $this->contrato->id,
                'paquete'            => $this->contrato->paquete,
                'costo_paquete'      => number_format($this->contrato->precio_de_compra),
                'metodo_pago'        => ($this->contrato->estancia->cuotas == 24) ? 'BI-WEEKLY' : 'Monthly',
                'pagos'              => $this->contrato->precio_de_compra / $this->contrato->estancia->cuotas,
                'fecha_primer_cobro' => $this->contrato->pagos_contrato[0]->fecha_de_cobro,
            ])
            ->attach(public_path() . '/files/contratos_usa/' . 'C' . $this->contrato->id . '.pdf', [
                'as'   => 'C' . $this->contrato->id . '.pdf',
                'mime' => 'application/pdf',
            ]);

    }
}
