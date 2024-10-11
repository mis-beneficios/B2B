<?php
namespace App\Traits;

use App;
use Illuminate\Support\Facades\Http;
use App\Incidencia;
use Auth;
use Carbon\Carbon;


trait LogTrait
{
    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2023-10-09
     * Agregar el historial de cambios al modelo ingresado
     * @param  array $temporal
     * @param  array $cambios
     * @return [boolean]
     */
    public function create_log($auth, $cambios, $temporal, $modelo)
    {
        $old_log = $modelo->log;
        $log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
        foreach ($cambios as $key => $value) {
            if (isset($key) && isset($temporal[$key])) {
            // if ($key != 'pass_hash' || $key != 'log') {
                $log .= "## **$key**: \n";
                $log .= "+ **$temporal[$key]** \n";
                $log .= "+ **$value** \n\n";
            }
        }
        $log .= "* * * \n\n";
        $modelo->log = $log . $old_log;
        $modelo->save();
    }

}
