<?php

// app/Jobs/ProcesarComisiones.php

namespace App\Jobs;

use App\Exports\ComisionesExport;
use App\Helpers\ComisionesHelper;
use App\Helpers\SmsHelper;
use App\JobNotifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class ProcesarComisiones implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600; // Tiempo en segundos

    protected $fechaInicio;
    protected $fechaFin;
    protected $ejecutivos;
    protected $id;
    private $comis;
    private $sms;

    public function __construct($fechaInicio, $fechaFin, $ejecutivos, $id = null)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin    = $fechaFin;
        $this->ejecutivos  = $ejecutivos;

        $this->id = $id;

        $this->comis = new ComisionesHelper;
        $this->sms   = new SmsHelper;
    }

    public function handle()
    {
        $not        = JobNotifications::findOrFail($this->id);
        $comisiones = $this->comis->getComisiones($this->fechaInicio, $this->fechaFin, $this->ejecutivos);

        $res = Excel::store(new ComisionesExport($comisiones), $not->job_name, 'filtrados');

        sleep(5);

        if ($res == true && Storage::disk('filtrados')->exists($not->job_name)) {
            if ($not != null && $not->numero != null) {
                $this->sms->enviar_sms($not->numero, $not->file);
                $not->estatus = 1;
            }
        } else {
            $this->sms->enviar_sms(7131150285, 'No se pudo generar el archivo de comisiones id: ' . $not->id);
            $not->estatus = 2;
        }
        $not->save();
    }

}
