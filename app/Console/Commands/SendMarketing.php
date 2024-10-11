<?php

namespace App\Console\Commands;

use App\Configuracion;
use App\Estancia;
use App\Mail\Mx\MailTelemarketing;
use App\User;
use Illuminate\Console\Command;
use Log;
use Mail;

class SendMarketing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:marketing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviamos correo de marketing digital a los clientes que hayan aceptado el envio de publicidad';

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
     *
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /**
         * Obtenemos las estancias activas para envar el mail con estas promociones
         */
        $estancias = Estancia::where('caducidad', config('app.vigencia'))->where('solosistema', 0)->where('estancia_paise_id', 1)->where('temporada', '!=', 'grupo')->get();

        /*
         * Creamos la bandera almacenandola en configuracion para generar una secuencia en caso de haber obtenido todos los usuarios que ya se les envio el mail
         */
        $secuencial = Configuracion::updateOrCreate(
            ['name' => 'secuencia_marketing'],
            ['data' => 0, 'notes' => 'Valor secuencial para la consulta de las alertas enviadar de marketing a clientes registrados desde el 2020']
        );

        /**
         * Usuarios que han autorizado el uso de datos, que fueron creados desde el 2020 y con secuencia activa para enviar mas de un mail
         */
        $users = User::where('autorizo', $secuencial->data)
            ->whereYear('created', '>=', '2020')
            ->where('username', 'not like', '%test%')
            ->where('username', 'not like', '%prueba%')
            ->where('role', 'client')
            ->where('alerta_enviada', $secuencial->data)
            ->limit(500)
            ->groupBy('username')
            ->orderBy('id', 'ASC')
            ->get();

        Log::info('Se han registardo ' . count($users) . ' emails para marketing publicitario');

        /**
         * Validamos si ya no existe ningun registro con la alerta_enviada en 0 se incremente en la secuencia para enviar un segundo mail de marketing con nuevas estancias aleatorias
         */
        if (count($users) == 0) {
            $secuencial = Configuracion::updateOrCreate(
                ['name' => 'secuencia_marketing'],
                ['data' => (intval($secuencial->data) + 1)]
            );
        }

        foreach ($users as $user) {

            $message = (new MailTelemarketing($estancias))->onQueue('marketing');
            Mail::to($user->username)->queue($message);

            $user->alerta_enviada = 1;
            $user->save();
        }
    }
}
