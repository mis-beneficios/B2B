<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notificacion;
use Illuminate\Support\Facades\Cookie;
use Log;
class DeleteCookie extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:cookie';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Eliminamos la cookie de la notificacion y actualizamos el estatus de la notificacion';

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

        $notificaciones = Notificacion::where('estatus',0)->where('activo_hasta', date('Y-m-d'))->get();

        if ($notificaciones != null) {
            foreach ($notificaciones as $notificacion) {
                $notificacion->estatus = 1;
                if ($notificacion->save()) {
                    Log::info('Se ha modificado la notificacion: ' . $notificacion->nombre);
                    Cookie::forget($notificacion->key_cache);
                }
            }
        }
        return 0;
    }
}
