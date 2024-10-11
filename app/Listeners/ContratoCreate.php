<?php

namespace App\Listeners;

use App\Contrato;
use App\Events\CreateContrato;

class ContratoCreate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CreateContrato  $event
     * @return void
     */
    public function handle(CreateContrato $event)
    {
        $contrato = Contrato::create($event->contrato);
        return $contrato;
    }
}
