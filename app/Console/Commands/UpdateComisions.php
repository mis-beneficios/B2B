<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Contrato;
use Log;

class UpdateComisions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:comision';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar comisiones';

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
        
        $contratos = Contrato::with('comisiones')->whereHas('convenio', function($query){
                        $query->where('paise_id', 1);
                    })
                    ->whereNotIn('estatus',['nuevo', 'suspendido','cancelado','sin_aprobar'])
                    ->whereIn('estatus_comisiones',['sin_procesar'])
                    ->where('comisiones_actualizadas', false)
                    // ->whereYear('created','>=', 2023)
                    ->orderBy('id', 'ASC')
                    // ->limit(500)
                    ->get();


        if (count($contratos) != 0 && $contratos != null) {
            foreach ($contratos as $contrato) {
                $pagos = $contrato->pagos()->where('cantidad','!=', 0.0)->where('segmento','!=', 0);
                $numSegmentos = $pagos->count();
                $primerPago   = $pagos->first();

                /**
                 * Validamos las comisiones por quincena
                 * && $numSegmentos <= 25 || $numSegmentos >= 34 
                 */
                if ($numSegmentos >= 23  && $numSegmentos <= 42) {
                    $com = $contrato->validarComisionQuincenal($primerPago);    
                }else
                
                /**
                 * Validamos las comisiones por semana
                 */
                if ($numSegmentos >= 47 && $numSegmentos <= 49 || $numSegmentos >= 71 && $numSegmentos <= 73) {
                    $com = $contrato->validarComisionSemanal($primerPago);
                }else    

                /**
                 * Validamos las comisiones por mes
                 */
                if ($numSegmentos >= 11 && $numSegmentos <= 13 || $numSegmentos >= 17 && $numSegmentos <= 19) {
                    $com = $contrato->validarComisionMensual($primerPago);
                }else{
                    $com = $contrato->validarComisionQuincenal($primerPago);    
                }
            }
            Log::info('Se han actualizado:' . count($contratos) . ' comisiones.');
        }
    }
}
