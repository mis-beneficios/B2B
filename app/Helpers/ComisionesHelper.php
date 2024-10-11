<?php

namespace App\Helpers;

use App\Comision;
use App\Contrato;
use App\Convenio;
use App\Pago;
use App\Salesgroup;
use Carbon\Carbon;
use DB;
use Log;

class ComisionesHelper
{
    public function generar_comisiones($contrato_id = null, $convenio_id = null)
    {
        $contrato = Contrato::findOrFail($contrato_id);
        $convenio = Convenio::findOrFail($contrato->convenio_id);
        $fecha    = Carbon::now();
        Comision::create([
            'contrato_id'      => $contrato->id,
            'pagable'          => 0,
            'pagado'           => 0,
            'estatus'          => 'Pendiente',
            'convenio_id'      => $convenio->id,
            'cliente_nombre'   => $contrato->cliente->fullName,
            'cliente_username' => $contrato->cliente->username,
            'cantidad'         => $convenio->comision_conveniador,
            'user_id'          => $convenio->user_id, // Estatico al creador por asignación del convenio.
            'concepto'         => 'Venta de contrato a conveniador',
            'campana_inicio'   => $convenio->campana_inicio,
            'campana_fin'      => $convenio->campana_fin,
            'created'          => $fecha,
            'modified'         => $fecha,

        ]);

        Comision::create([
            'contrato_id'      => $contrato->id,
            'pagable'          => 0,
            'pagado'           => 0,
            'estatus'          => 'Pendiente',
            'convenio_id'      => $convenio->id,
            'cliente_nombre'   => $contrato->cliente->fullName,
            'cliente_username' => $contrato->cliente->username,
            'cantidad'         => 100.0,
            'user_id'          => $contrato->padre->user_id, // Estatico al creador por asignación del convenio.
            'concepto'         => 'Venta de contrato a ejecutivo',
            'created'          => $fecha,
            'modified'         => $fecha,

        ]);

        try {
            Comision::create([
                'contrato_id'      => $contrato->id,
                'pagable'          => 0,
                'pagado'           => 0,
                'estatus'          => 'Pendiente',
                'convenio_id'      => $convenio->id,
                'cliente_nombre'   => $contrato->cliente->fullName,
                'cliente_username' => $contrato->cliente->username,
                'cantidad'         => 15.0,
                'user_id'          => ($contrato->padre->user->equipo) ? $contrato->padre->user->equipo->user_id : '', // Estatico al creador por asignación del convenio.
                'concepto'         => 'Venta de contrato a supervisor',
                'created'          => $fecha,
                'modified'         => $fecha,
            ]);
        } catch (\Exception $e) {
            Log::warning($e->getMessage());  
        }

        return true;

        // return $this->supervisor($contrato->padre_id);
    }

    public function supervisor($id)
    {
        $sup = Salesgroup::where('id', $id)->get();
    }

    /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-11-07
     * Consulta de comisiones para los ejecutivos seleccionados
     * @param  [date] $fecha_inicio
     * @param  [date] $fecha_fin
     * @param  [array] $users
     * @return [array] $datos
     */
    public function getComisiones($fecha_inicio, $fecha_fin, $users)
    {

        DB::flushQueryLog();
        
        $datos = DB::select("
                select
                    contratos.id, 
                    contratos.tipo_llamada,
                    contratos.created as 'fecha_de_venta',
                    min(pagos.fecha_de_pago) as 'primer_pago',
                    min(pagos.estatus) as 'estatus_pago',
                    min(pagos.segmento) as 'segmento_pago',
                    pagos.id as pago_id,
                    concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista,
                    case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as 'equipo',
                    convenios.empresa_nombre,
                    vendedor.title as vendedor,
                    comisiones.cliente_nombre,
                    comisiones.estatus,
                    comisiones.motivo_rechazo,
                    comisiones.modified,
                    comisiones.cantidad,
                    contratos.user_id as user_id,
                    comisiones.id as comision_id,
                    contratos.tipo_pago
                from
                    comisiones
                    inner join
                    users ON comisiones.user_id = users.id
                    left outer join
                    salesgroups ON users.salesgroup_id = salesgroups.id
                    inner join
                    contratos ON comisiones.contrato_id = contratos.id
                    inner join
                    convenios ON comisiones.convenio_id = convenios.id
                    inner join
                    pagos ON comisiones.contrato_id = pagos.contrato_id
                    LEFT JOIN
                    padres AS vendedor ON vendedor.id = contratos.padre_id
                where
                comisiones.estatus NOT IN ( 'Finiquitadas', 'Pagada')
                    and pagos.estatus in ('Pagado')
                    and pagos.segmento not in (0)
                    and users.username in ({$users})

                group by contratos.id , contratos.created , users.role , users.nombre , users.apellidos , salesgroups.title
                having min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'
            UNION
                select
                    contratos.id, 
                    contratos.tipo_llamada,
                    contratos.created as 'fecha_de_venta',
                    min(pagos.fecha_de_pago) as 'primer_pago',
                    min(pagos.estatus) as 'estatus_pago',
                    min(pagos.segmento) as 'segmento_pago',
                    pagos.id as pago_id,
                    concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista,
                    case
                    when salesgroups.title is null then 'Sin asignación'
                    else salesgroups.title end as 'equipo',
                    convenios.empresa_nombre,
                    vendedor.title as vendedor,
                    comisiones.cliente_nombre,
                    comisiones.estatus,
                    comisiones.motivo_rechazo,
                    comisiones.modified,
                    comisiones.cantidad,
                    contratos.user_id as user_id,
                    comisiones.id as comision_id,
                    contratos.tipo_pago
                from
                    comisiones
                    inner join
                    users ON comisiones.user_id = users.id
                    left outer join
                    salesgroups ON users.salesgroup_id = salesgroups.id
                    inner join
                    contratos ON comisiones.contrato_id = contratos.id
                    inner join
                    convenios ON comisiones.convenio_id = convenios.id
                    inner join
                    pagos ON comisiones.contrato_id = pagos.contrato_id
                    LEFT JOIN
                    padres AS vendedor ON vendedor.id = contratos.padre_id
                where
                comisiones.estatus NOT IN ( 'Finiquitadas', 'Pagable' ,'Pagada')
                    and pagos.estatus IN ('Rechazado')
                    and pagos.segmento not in (0)
                    and users.username in ({$users})

                group by contratos.id , contratos.created , users.role , users.nombre , users.apellidos , salesgroups.title
                having min(pagos.fecha_de_pago)  BETWEEN '{$fecha_inicio}' and '{$fecha_fin}'
            UNION
                select
                    contratos.id, 
                    contratos.tipo_llamada,
                    contratos.created as 'fecha_de_venta',
                    min(pagos.fecha_de_pago) as 'primer_pago',
                    min(pagos.estatus) as 'estatus_pago',
                    min(pagos.segmento) as 'segmento_pago',
                    pagos.id as pago_id,
                    concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista,
                    case
                    when salesgroups.title is null then 'Sin asignación'
                    else salesgroups.title end as 'equipo',
                    convenios.empresa_nombre,
                    vendedor.title as vendedor,
                    comisiones.cliente_nombre,
                    comisiones.estatus,
                    comisiones.motivo_rechazo,
                    comisiones.modified,
                    comisiones.cantidad,
                    contratos.user_id as user_id,
                    comisiones.id as comision_id,
                    contratos.tipo_pago
                from
                    comisiones
                    inner join
                    users ON comisiones.user_id = users.id
                    left outer join
                    salesgroups ON users.salesgroup_id = salesgroups.id
                    inner join
                    contratos ON comisiones.contrato_id = contratos.id
                    inner join
                    convenios ON comisiones.convenio_id = convenios.id
                    inner join
                    pagos ON comisiones.contrato_id = pagos.contrato_id
                    LEFT JOIN
                    padres AS vendedor ON vendedor.id = contratos.padre_id
                where
                comisiones.estatus NOT IN ( 'Finiquitadas', 'Pagable', 'Pendiente','Pagada' )
                    and pagos.estatus IN ('Por Pagar')
                    and pagos.segmento not in (0)
                    and users.username in ({$users})

                group by contratos.id , contratos.created , users.role , users.nombre , users.apellidos , salesgroups.title, comisionista
                having min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'
            order by comisionista , empresa_nombre");

        return $datos;
    }

    public function getComisiones_($fecha_inicio, $fecha_fin, $users)
    {

                // dd($fecha_inicio, $fecha_fin, $users);
        $resultado1 = DB::table('comisiones')
            ->join('users', 'comisiones.user_id', '=', 'users.id')
            ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
            ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
            ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
            ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
            ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
            ->select(
                'contratos.id',
                'contratos.tipo_llamada',
                'contratos.created as fecha_de_venta',
                DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
                DB::raw('min(pagos.estatus) as estatus_pago'),
                DB::raw('min(pagos.segmento) as segmento_pago'),
                'pagos.id as pago_id',
                DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
                DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
                'convenios.empresa_nombre',
                'vendedor.title as vendedor',
                'comisiones.cliente_nombre',
                'comisiones.estatus',
                'comisiones.motivo_rechazo',
                'comisiones.modified',
                'comisiones.cantidad',
                'comisiones.campana_inicio',
                'comisiones.campana_fin',
                'contratos.user_id as user_id',
                'comisiones.id as comision_id',
                'contratos.tipo_pago'
            )
            ->whereIn('users.username', $users)
            ->whereNotIn('comisiones.estatus', ['Finiquitadas', 'Pagada'])
            ->whereIn('pagos.estatus', ['Pagado'])
            ->whereNotIn('pagos.segmento', [0])
            ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
            ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'");

        $resultado2 = DB::table('comisiones')
            ->join('users', 'comisiones.user_id', '=', 'users.id')
            ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
            ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
            ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
            ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
            ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
            ->select(
                'contratos.id',
                'contratos.tipo_llamada',
                'contratos.created as fecha_de_venta',
                DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
                DB::raw('min(pagos.estatus) as estatus_pago'),
                DB::raw('min(pagos.segmento) as segmento_pago'),
                'pagos.id as pago_id',
                DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
                DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
                'convenios.empresa_nombre',
                'vendedor.title as vendedor',
                'comisiones.cliente_nombre',
                'comisiones.estatus',
                'comisiones.motivo_rechazo',
                'comisiones.modified',
                'comisiones.cantidad',
                'comisiones.campana_inicio',
                'comisiones.campana_fin',
                'contratos.user_id as user_id',
                'comisiones.id as comision_id',
                'contratos.tipo_pago'
            )
            ->whereIn('users.username', $users)
            ->whereNotIn('comisiones.estatus', [ 'Finiquitadas', 'Pagable' ,'Pagada'])
            ->whereIn('pagos.estatus', ['Pagado'])
            ->whereNotIn('pagos.segmento', [0])
            ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
            ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'");
            // ->union($resultado1);

        $resultado = DB::table('comisiones')
            ->join('users', 'comisiones.user_id', '=', 'users.id')
            ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
            ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
            ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
            ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
            ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
            ->select(
                'contratos.id',
                'contratos.tipo_llamada',
                'contratos.created as fecha_de_venta',
                DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
                DB::raw('min(pagos.estatus) as estatus_pago'),
                DB::raw('min(pagos.segmento) as segmento_pago'),
                'pagos.id as pago_id',
                DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
                DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
                'convenios.empresa_nombre',
                'vendedor.title as vendedor',
                'comisiones.cliente_nombre',
                'comisiones.estatus',
                'comisiones.motivo_rechazo',
                'comisiones.modified',
                'comisiones.cantidad',
                'comisiones.campana_inicio',
                'comisiones.campana_fin',
                'contratos.user_id as user_id',
                'comisiones.id as comision_id',
                'contratos.tipo_pago'
            )
            ->whereIn('users.username', $users)
            ->whereNotIn('comisiones.estatus', ['Finiquitadas', 'Pagable', 'Pendiente','Pagada'])
            ->whereIn('pagos.estatus', ['Pagado'])
            ->whereNotIn('pagos.segmento', [0])
            ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
            ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'")
            ->union($resultado1)
            ->union($resultado2)
            ->orderBy('comisionista')
            ->orderBy('empresa_nombre')
            ->get();

        dd($resultado);
    }

    public function generar_comision_enganche($contrato_id = null, $pago_id = null)
    {
        $contrato = Contrato::findOrFail($contrato_id);
        $convenio = Convenio::findOrFail($contrato->convenio_id);
        $fecha    = Carbon::now();


        Comision::create([
            'contrato_id'      => $contrato->id,
            'pagable'          => 0,
            'pagado'           => 0,
            'estatus'          => 'Pendiente',
            'convenio_id'      => $convenio->id,
            'cliente_nombre'   => $contrato->cliente->fullName,
            'cliente_username' => $contrato->cliente->username,
            'cantidad'         => 150.0,
            'user_id'          => $contrato->padre->user_id, // Estatico al creador por asignación del convenio.
            'concepto'         => 'Pago de enganche a ejecutivo',
            'created'          => $fecha,
            'modified'         => $fecha,
            'pago_id'          => $pago_id,
            'tipo'             => 'Enganche',
        ]);

        return true;
    }



    public function validar_comision($comision)
    {
        /*
        Definimos las variables que se usaran en la validacion de las comisiones
         */            
        $pago_inicial = 1;
        $valida_pago_inicial = false;
        $est_pago_comision = '';
        
        $pagos = Pago::query();

        $info_pagos = $pagos->where('segmento','!=',0)->where('contrato_id', $comision->id)->get();          
        
        $primer_pago = $info_pagos->where('segmento', $pago_inicial)->first();



        return $primer_pago;
    }




        /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2023-12-19
     * Consulta de comisiones de enganches para los ejecutivos seleccionados
     * @param  [date] $fecha_inicio
     * @param  [date] $fecha_fin
     * @param  [array] $users
     * @return [array] $datos
     */
    public function getComisionesEnganche($fecha_inicio, $fecha_fin, $user)
    {

        $users = "'".$user."'";
        $datos = DB::select("
                select
                    contratos.id, 
                    contratos.tipo_llamada,
                    contratos.created as 'fecha_de_venta',
                    min(pagos.fecha_de_pago) as 'primer_pago',
                    min(pagos.estatus) as 'estatus_pago',
                    min(pagos.segmento) as 'segmento_pago',
                    pagos.id as pago_id,
                    concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista,
                    case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as 'equipo',
                    convenios.empresa_nombre,
                    vendedor.title as vendedor,
                    comisiones.cliente_nombre,
                    comisiones.estatus,
                    comisiones.motivo_rechazo,
                    comisiones.modified,
                    comisiones.cantidad,
                    comisiones.campana_inicio,
                    comisiones.campana_fin,
                    contratos.user_id as user_id,
                    comisiones.id as comision_id,
                    contratos.tipo_pago
                from
                    comisiones
                    inner join
                    users ON comisiones.user_id = users.id
                    left outer join
                    salesgroups ON users.salesgroup_id = salesgroups.id
                    inner join
                    contratos ON comisiones.contrato_id = contratos.id
                    inner join
                    convenios ON comisiones.convenio_id = convenios.id
                    inner join
                    pagos ON comisiones.contrato_id = pagos.contrato_id
                    LEFT JOIN
                    padres AS vendedor ON vendedor.id = contratos.padre_id
                where
                comisiones.estatus NOT IN ( 'Finiquitadas', 'Pagada')
                    and comisiones.tipo IN ('Enganche')
                    and pagos.estatus in ('Pagado')
                    and users.username in ({$users})

                group by contratos.id , contratos.created , users.role , users.nombre , users.apellidos , salesgroups.title
                having min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'
            UNION
                select
                    contratos.id, 
                    contratos.tipo_llamada,
                    contratos.created as 'fecha_de_venta',
                    min(pagos.fecha_de_pago) as 'primer_pago',
                    min(pagos.estatus) as 'estatus_pago',
                    min(pagos.segmento) as 'segmento_pago',
                    pagos.id as pago_id,
                    concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista,
                    case
                    when salesgroups.title is null then 'Sin asignación'
                    else salesgroups.title end as 'equipo',
                    convenios.empresa_nombre,
                    vendedor.title as vendedor,
                    comisiones.cliente_nombre,
                    comisiones.estatus,
                    comisiones.motivo_rechazo,
                    comisiones.modified,
                    comisiones.cantidad,
                    comisiones.campana_inicio,
                    comisiones.campana_fin,
                    contratos.user_id as user_id,
                    comisiones.id as comision_id,
                    contratos.tipo_pago
                from
                    comisiones
                    inner join
                    users ON comisiones.user_id = users.id
                    left outer join
                    salesgroups ON users.salesgroup_id = salesgroups.id
                    inner join
                    contratos ON comisiones.contrato_id = contratos.id
                    inner join
                    convenios ON comisiones.convenio_id = convenios.id
                    inner join
                    pagos ON comisiones.contrato_id = pagos.contrato_id
                    LEFT JOIN
                    padres AS vendedor ON vendedor.id = contratos.padre_id
                where
                comisiones.estatus NOT IN ( 'Finiquitadas', 'Pagable' ,'Pagada')
                    and comisiones.tipo IN ('Enganche')
                    and pagos.estatus IN ('Rechazado')
                    and users.username in ({$users})

                group by contratos.id , contratos.created , users.role , users.nombre , users.apellidos , salesgroups.title
                having min(pagos.fecha_de_pago)  BETWEEN '{$fecha_inicio}' and '{$fecha_fin}'
            UNION
                select
                    contratos.id, 
                    contratos.tipo_llamada,
                    contratos.created as 'fecha_de_venta',
                    min(pagos.fecha_de_pago) as 'primer_pago',
                    min(pagos.estatus) as 'estatus_pago',
                    min(pagos.segmento) as 'segmento_pago',
                    pagos.id as pago_id,
                    concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista,
                    case
                    when salesgroups.title is null then 'Sin asignación'
                    else salesgroups.title end as 'equipo',
                    convenios.empresa_nombre,
                    vendedor.title as vendedor,
                    comisiones.cliente_nombre,
                    comisiones.estatus,
                    comisiones.motivo_rechazo,
                    comisiones.modified,
                    comisiones.cantidad,
                    comisiones.campana_inicio,
                    comisiones.campana_fin,
                    contratos.user_id as user_id,
                    comisiones.id as comision_id,
                    contratos.tipo_pago
                from
                    comisiones
                    inner join
                    users ON comisiones.user_id = users.id
                    left outer join
                    salesgroups ON users.salesgroup_id = salesgroups.id
                    inner join
                    contratos ON comisiones.contrato_id = contratos.id
                    inner join
                    convenios ON comisiones.convenio_id = convenios.id
                    inner join
                    pagos ON comisiones.contrato_id = pagos.contrato_id
                    LEFT JOIN
                    padres AS vendedor ON vendedor.id = contratos.padre_id
                where
                comisiones.estatus NOT IN ( 'Finiquitadas', 'Pagable', 'Pendiente','Pagada' )
                    and comisiones.tipo IN ('Enganche')
                    and pagos.estatus IN ('Por Pagar')
                    and users.username in ({$users})

                group by contratos.id , contratos.created , users.role , users.nombre , users.apellidos , salesgroups.title, comisionista
                having min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'
            order by comisionista , empresa_nombre");

        return $datos;
    }
}
