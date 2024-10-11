<?php

namespace App\Console\Commands;

use App\Sorteo;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class UpdateSorteo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:sorteo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualiza el estatus de los sorteos seleccionados una vez haya pasado la fecha de lanzamiento';

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
        $hoy     = Carbon::now()->format('Y-m-d');
        $sorteos = Sorteo::where('fecha_fin', '<', $hoy)->get();

        foreach ($sorteos as $sorteo) {
            $sorteo->flag = 1;
            $sorteo->save();
        }

        Log::debug('Se han actualizado el estatus de ' . count($sorteos) . ' sorteos');
    }
}
