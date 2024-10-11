<?php
/**
 *  Generaror de logs, registro de cambios realizados en el sistema administrativo
 *  Autor: Isw. Diego Enrique Sanchez
 *  Creado: 2021-09-19
 */
namespace App\Helpers;

use App\Concal;
use App\PagoLog;

class LogHelper
{

    public function __construct()
    {

    }

    public function pagos_log($request, $contrato, $precio, $cambio_estancia = null)
    {
        $log_pagos = "Recalculo a " . $request->num_segmentos . " segmento(s) cubriendo $" . $precio . ". Siguiente cobro: " . $request->fecha_primer_descuento . "";

        $contrato->pagos_log = $log_pagos;
        $contrato->save();
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-15
     * modificamos el pago_log del contrato definiendo el cambio de estancia
     * @param  [objeto] $contrato
     */
    public function pagos_log_cambio_estancia($contrato)
    {
        $log_pagos = "Cambio de estancia";

        $contrato->pagos_log = $log_pagos;
        $contrato->save();
    }

    public function add_log_contract($auth, $tipo = null, $request, $contrato, $precio)
    {
        $old_log = $contrato->log;

        $log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
        $log .= "## **" . $tipo . "**: \n";
        if ($contrato->pagos_log != null) {
            $log .= "+ **$contrato->pagos_log**\n\n";
        } else {
            $log .= "+ ****\n";
        }
        $log .= "+ **Recalculo a " . $request->num_segmentos . " segmento(s) cubriendo $" . number_format($precio, 2, '.', '') . ". Siguiente cobro: " . $request->fecha_primer_descuento . "**\n";
        // $log .= "___________________________________ \n";
        // $log .= "<br>\n";
        $log .= "* * *  \n";

        $contrato->log = $log . $old_log;
        $contrato->save();
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-27
     *
     * Historial de acciones al registro de reservaciones (nota*)
     * @param [objeto] $auth          objeto del usuario logueado en el sistema
     * @param [string] $tipo        define el tipo de accion que se realizara
     * @param [objeto] $reservacion   objeto de reservacion para evitar consultar nuevamente
     */
    public function add_log_reservacion($auth, $tipo = null, $reservacion)
    {
        $old_log = $reservacion->notas;

        $log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
        $log .= "## **" . ($tipo) ? $tipo : 'Nota' . "**: \n";
        $log .= "+ ****\n";
        $log .= "+ **Reservacion ingresada por cliente**\n\n";
        // $log .= "___________________________________ \n";
        $log .= "* * *  \n\n";

        $reservacion->notas = $log . $old_log;
        $reservacion->save();
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2022-09-21
     * Modificamos el log del registro mediante los cambios realizados recorriendo el array de los cambios a aplicar
     * @param  array $temporal
     * @param  array $cambios
     * @return [boolean]
     */
    public function reservacion_log_editar($auth, $cambios, $temporal, $reservacion)
    {

        if (isset($cambios['estatus'])) {

            $old_log = $reservacion->notas;

            $notas_new = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
            $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";

            foreach ($cambios as $key => $value) {
                // if ($key == 'estatus') {
                $notas_new .= "## **" . $key . "**: \n";
                $notas_new .= "+ **" . $temporal[$key] . "**\n";
                $notas_new .= "+ **" . $value . "** \n";
                // }
            }
            $notas_new .= "* * *  \n\n";

            // $log .= "___________________________________ \n";
            $reservacion->notas = $notas_new . $old_log;

            // return $log;
            $reservacion->save();
        }
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-15
     *
     * Modificamos el historial del contrato con la estancia anterior y los datos de la nueva
     *
     * @param  [type] $auth     [description]
     * @param  [type] $tipo     [description]
     * @param  [type] $request  [description]
     * @param  [type] $contrato [description]
     * @param  [type] $precio   [description]
     * @return [type]           [description]
     */
    public function contrato_log_cambio_estancia($auth, $contrato, $estancia)
    {
        $old_log = $contrato->log;

        $log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
        $log .= "## **estancia_id**: \n";
        $log .= "+ **$contrato->estancia_id**\n";
        $log .= "+ **$estancia->id**\n";

        $log .= "## **paquete**: \n";
        $log .= "+ **$contrato->paquete**\n";
        $log .= "+ **$estancia->title**\n";

        $log .= "## **precio_de_compra**: \n";
        $log .= "+ **" . number_format($contrato->precio_de_compra, 2) . "**\n";
        $log .= "+ **" . number_format($estancia->precio, 2) . "**\n";

        $log .= "## **noches**: \n";
        $log .= "+ **$contrato->noches**\n";
        $log .= "+ **$estancia->noches**\n";
        $log .= "## **niños**: \n";
        $log .= "+ **$contrato->ninos**\n";
        $log .= "+ **$estancia->ninos**\n\n";

        // $log .= "___________________________________ \n";
        $log .= "* * * \n\n";

        $contrato->log = $log . $old_log;

        $contrato->save();
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-10-17
     * Modificamos el log del registro mediante los cambios realizados recorriendo el array de los cambios a aplicar
     * @param  array $temporal
     * @param  array $cambios
     * @return [boolean]
     */
    public function contrato_log_editar($auth, $cambios, $temporal, $contrato)
    {

        $old_log = $contrato->log;

        $log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";

        foreach ($cambios as $key => $value) {
            $log .= "## **" . $key . "**: \n";
            $log .= "+ **" . $temporal[$key] . "** \n";
            $log .= "+ **" . $value . "** \n\n";
        }

        $log .= "* * * \n\n";
        // $log .= "___________________________________ \n";
        $contrato->log = $log . $old_log;

        // return $log;
        $contrato->save();
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2022-01-30
     * Modificar el historial del cambio de estatus o motivo de suspencion
     * @param  array $temporal
     * @param  array $cambios
     * @return [boolean]
     */
    public function contrato_log_cambio_estatus($auth, $cambios, $motivo_estatus, $contrato)
    {

        $contrato->motivo_estatus = $motivo_estatus;
        if ($contrato->save()) {
            return true;
        }
    }

    public function add_segmento_log($pago, $auth)
    {
        $log_pago = PagoLog::where('pago_id', $pago->id)->first();

        $log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
        $log .= "### Tarjeta:  ** n/a  -> n/a** \n";
        $log .= "### Segmento:  ** " . $pago->segmento . " -> " . $pago->segmento . "** \n";
        $log .= "### Estatus:  **" . $pago->estatus . " -> " . $pago->estatus . "** \n";
        $log .= "### Cantidad:  **" . number_format($pago->cantidad) . " -> " . number_format($pago->cantidad) . "** \n";
        $log .= "### Cobro:  **" . $pago->fecha_de_cobro . " -> " . $pago->fecha_de_cobro . "** \n";
        $log .= "### Pago:  **" . $pago->fecha_de_pago . " -> " . $pago->fecha_de_pago . "** \n\n";
        // $log .= "___________________________________ \n";
        $log .= "* * * \n\n";

        if ($log_pago == null) {
            $new          = new PagoLog;
            $new->pago_id = $pago->id;
            $new->notas   = $log;
            $new->save();
        } else {
            $old_log         = $log_pago->notas;
            $log_pago->notas = $log . $old_log;
            $log_pago->save();
        }

        return true;

    }

    /**
     * Autor: Isw Diego Enrique Sanchez
     * Creado: 2022-03-01
     * @param  [type] $auth     [description]
     * @param  [type] $concal   [description]
     * @param  [type] $temporal [description]
     * @param  [type] $cambios  [description]
     * @return [type]           [description]
     */
    public function concal_log($auth, $cambios, $temporal, $concal)
    {
        // dd($concal);
        // $con     = Concal::findOrFail($concal);
        $con     = $concal;
        $old_log = $con->log;

        $new_log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $new_log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";

        foreach ($cambios as $key => $value) {

            // if ($key != 'nextel' && $key != 'corporativo' && $key != 'sucursales' && $key != 'sucursal_lugar') {
            if ($key == 'observaciones') {
                $new_log .= "## **" . $key . "**: \n";
                // $new_log .= $temporal[$key] . "\n";
                // $new_log .= str_replace("\n", '', $value) . "\n";
                $new_log .= $value . "\n";
            } else {
                // if (isset($key)) {
                $new_log .= "## **" . $key . "**: \n";
                $new_log .= "+ **" . $temporal[$key] . "** \n";
                $new_log .= "+ **" . $value . "** \n\n";
                // }
            }
            // }

        }
        $new_log .= "* * *  \n\n";
        $con->log = $new_log . $old_log;

        $con->modified = date('Y-m-d');
        $con->save();
        return $con->log;
    }

    public function add_reservacion($auth, $reservacion)
    {

        $old_log = $reservacion->notas;

        $notas_new = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $notas_new .= "### Fecha: **" . date('Y-m-d H:i:s') . "**\n";

        $notas_new .= "## **Nota:**: \n";
        $notas_new .= "+ ** Reservacion ingresada por ejecutivo **\n";
        $notas_new .= "+ **\n";

        // $notas_new .= "## **nombre_de_quien_sera_la_reservacion**: \n";
        // $notas_new .= "+ **" . $reservacion->nombre_de_quien_sera_la_reservacion . "**\n";
        // $notas_new .= "+ **\n";

        // $notas_new .= "## **destino**: \n";
        // $notas_new .= "+ **" . $reservacion->destino . "**\n";
        // $notas_new .= "+ **\n";

        // $notas_new .= "## **fechas**: \n";
        // $notas_new .= "+ **" . $reservacion->fecha_de_ingreso . ' al ' . $reservacion->fecha_de_salida . "**\n";
        // $notas_new .= "+ **\n";

        // $notas_new .= "## **estancia_id**: \n";
        // $notas_new .= "+ **" . $reservacion->estancia_id . "**\n";
        // $notas_new .= "+ **\n";

        // $notas_new .= "## **title**: \n";
        // $notas_new .= "+ **" . $reservacion->title . "**\n";
        // $notas_new .= "+ **\n";

        // $notas_new .= "## **tipo**: \n";
        // $notas_new .= "+ **" . $reservacion->tipo . "**\n";
        // $notas_new .= "+ **\n";

        // $notas_new .= "## **regione_id**: \n";
        // $notas_new .= "+ **" . $reservacion->regione_id . "**\n";
        // $notas_new .= "+ **\n";

        // $notas_new .= "## **tarjeta_id**: \n";
        // $notas_new .= "+ **" . $reservacion->tarjeta_id . "**\n";
        // $notas_new .= "+ **\n";

        $notas_new .= "* * *  \n";
        $reservacion->notas = $notas_new . $old_log;
        $reservacion->save();
    }

    /**
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 20223-01-02
     * Creamos el log de la crecion de la sys_key del contrato
     *
     * @param  [type] $auth     [description]
     * @return [type]           [description]
     */
    public function contrato_log_sys_key($auth, $new_syskey)
    {
        $old_log = $new_syskey->log;

        $log = "\n \n#**" . $auth->fullName . "**, [" . $auth->username . "]: \n";
        $log .= "### Fecha: **" . date('Y-m-d H:i:s') . "** \n";
        $log .= "## **sys_key**: \n";
        $log .= "+ **  **\n";
        $log .= "+ **$new_syskey->sys_key**\n";

        $log .= "* * * \n\n";

        $new_syskey->log = $log . $old_log;

        $new_syskey->save();
    }

}
