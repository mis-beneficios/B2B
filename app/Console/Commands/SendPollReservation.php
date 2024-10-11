<?php

namespace App\Console\Commands;

use App\Mail\Mx\EncuestaReservacion;
use App\Reservacion;
use Illuminate\Console\Command;
use Log;
use Mail;

class SendPollReservation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar encuesta de calidad a clientes con reservacion del dia actual';

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
        $res = Reservacion::where('fecha_de_salida', date('Y-m-d'))->where('estatus', 'Cupon Enviado')->get();
        foreach ($res as $reservacion) {
            try {
                Mail::to($reservacion->cliente->username)->send(new EncuestaReservacion($reservacion));
                Log::notice('Se ha enviado encuesta a: ' . $reservacion->cliente->fullName);
            } catch (Exception $e) {
                Log::notice('No se pudo enviar la encuesta a: ' . $reservacion->cliente->fullName);
            }
        }
    }
}
