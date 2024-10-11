<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\IntentoCompra;
use App\Mail\Mx\IntentoCompra as IC;
use Mail;
class IntentoCompraAlerta implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $compra;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(IntentoCompra $compra)
    {
        $this->compra = $compra;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->compra->cliente->username)->queue(new IC($this->compra));
    }
}
