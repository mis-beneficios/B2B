<?php

namespace App\Jobs;

use App\Exports\BaseExport;
use App\Helpers\FilterHelper;
use App\Helpers\SmsHelper;
use App\JobNotifications;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Storage;

class ExportBases implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600; // Tiempo en segundos

    protected $fecha_i, $fecha_f, $ejecutivos_select, $estatus_folio, $file_name;

    private $sms;
    private $filter;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($fecha_inicio, $fecha_fin, $ejecutivos, $estatus, $archivo_name)
    {

        $this->fecha_i           = $fecha_inicio;
        $this->fecha_f           = $fecha_fin;
        $this->ejecutivos_select = $ejecutivos;
        $this->estatus_folio     = $estatus;
        $this->file_name         = $archivo_name;
        $this->sms               = new SmsHelper;
        $this->filter            = new FilterHelper;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $not   = JobNotifications::where('job_name', $this->file_name)->first();
        $datos = $this->filter->filterBase($this->fecha_i, $this->fecha_f, $this->ejecutivos_select, $this->estatus_folio);

        // dd($datos);
        $res = Excel::store(new BaseExport($datos), $this->file_name, 'filtrados');
        sleep(5);

        if ($res == true && Storage::disk('filtrados')->exists($this->file_name)) {
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
