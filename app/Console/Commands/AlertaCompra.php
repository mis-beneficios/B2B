<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\IntentoCompra;
use App\Estancia;
use Mail;
use App\Mail\Mx\IntentoCompra as IC;
use App\Jobs\IntentoCompraAlerta as JobIntentoCom;
use Log;


class AlertaCompra extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:alerta';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia email marketing con la estancia que no finalizo la compra';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        /*
         * Obtenemos todos los intentos de compra que no fueron finalizadas para enviar el correo de recordatorio
         */
        $intentos = IntentoCompra::where('estatus', 0)
        ->get();

        Log::info('Se han registrado '.count($intentos). 'intentos de compra');
        // ->where('user_id', 690065)->get();
        // ->limit(1)->get();

        foreach ($intentos as $compra) {
            // Mail::to('dsanchez@pacifictravels.mx')->queue(new IC($compra));

            /**
             * Enviamos el correo de recordatorio para finalizar la compra mediante colas 
             * para no saturar el servidor y que se ejecuten en segundo plano.
             * Comprobar la ejecucion del comando work para la escucha de las coclas y procesos en cola 
             */
            if ($compra->cliente != null) {
                Mail::to($compra->cliente->username)
                // ->bcc('dsanchez@pacifictravels.mx')
                ->queue(new IC($compra));
            
                $compra->intento++;
                if ($compra->intento == 5) {
                    /**
                     * 1.- finalizo la compra
                     * 2.- Se completaron los intentos de envio de correo
                     */
                    $compra->estatus = 2;
                }

                $compra->save();
            }
        }

        return 0;

    }
}
