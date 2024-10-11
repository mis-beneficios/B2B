<?php

namespace App\Observers;

use App\Contrato;

class ContratosObserver
{
    /**
     * Handle the contrato "created" event.
     *
     * @param  \App\Contrato  $contrato
     * @return void
     */
    public function created(Contrato $contrato)
    {
        //
    }

    /**
     * Handle the contrato "updated" event.
     *
     * @param  \App\Contrato  $contrato
     * @return void
     */
    public function updated(Contrato $contrato)
    {
        //
    }

    /**
     * Handle the contrato "deleted" event.
     *
     * @param  \App\Contrato  $contrato
     * @return void
     */
    public function deleted(Contrato $contrato)
    {
        //
    }

    /**
     * Handle the contrato "restored" event.
     *
     * @param  \App\Contrato  $contrato
     * @return void
     */
    public function restored(Contrato $contrato)
    {
        //
    }

    /**
     * Handle the contrato "force deleted" event.
     *
     * @param  \App\Contrato  $contrato
     * @return void
     */
    public function forceDeleted(Contrato $contrato)
    {
        //
    }
}
