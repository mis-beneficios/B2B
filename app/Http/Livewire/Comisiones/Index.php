<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;
use Auth;
use App\User;
use App\Convenio;
use DB;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
    public $rango_fechas, $comisiones;
    public $ejecutivos_select = [];
    public $datos_comisiones;
    public $comis;



    public function render()
    {
        if (Auth::user()->role == 'conveniant') {
            $convenios = Convenio::where('user_id', Auth::id())->get();
        } else {
            $convenios = false;
        }

        if (Auth::user()->role == 'supervisor') {
            $ejecutivos = User::whereIn('role', ['sales', 'supervisor'])->whereIn('salesgroup_id', [Auth::user()->salesgroup_id])->get();
        } else {
            $ejecutivos = User::whereIn('role', ['sales', 'supervisor'])->get();
        }

        if ($this->rango_fechas) {    
            $fechas = explode(' al ', $this->rango_fechas);
            $fecha_inicio = $fechas[0];
            $fecha_fin = $fechas[1];
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
                ->whereNotIn('comisiones.estatus', ['Finiquitadas'])
                ->where('pagos.estatus', 'Pagado')
                ->whereIn('users.username', $this->ejecutivos_select)
                // ->whereNotIn('pagos.segmento', [0])
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
                ->whereNotIn('comisiones.estatus', [ 'Finiquitadas', 'Pagable'])
                ->whereIn('pagos.estatus', ['Rechazado'])
                ->whereIn('users.username', $this->ejecutivos_select)
                ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
                ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'");

            $data_comisiones = DB::table('comisiones')
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
                ->whereNotIn('comisiones.estatus', ['Finiquitadas', 'Pagable', 'Pendiente', 'Pagada'])
                ->whereIn('pagos.estatus', ['Por Pagar'])
                ->whereIn('users.username', $this->ejecutivos_select)
                ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
                ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'")
                ->union($resultado1)
                ->union($resultado2)
                ->orderBy('comisionista')
                ->orderBy('empresa_nombre')
                ->paginate(20);
        }else{
            $data_comisiones = false;
        }        


            // dd($data_comisiones);
        return view('livewire.comisiones.index', ['convenios' => $convenios,'ejecutivos' => $ejecutivos, 'comisiones' => $data_comisiones]);
    }

    public function getComisiones()
    {
        return 0;
    }

    // function getComisiones()
    // {

    //     // dd($this->rango_fechas, $this->ejecutivos_select);

    //     $fechas = explode(' al ', $this->rango_fechas);
    //     $fecha_inicio = $fechas[0];
    //     $fecha_fin = $fechas[1];
    //     if ($this->ejecutivos_select) {
    //         $ejecutivos = implode(',',  $this->ejecutivos_select);
    //     } 

    //     // dd($this->ejecutivos_select, $fecha_inicio, $fecha_fin);
    //      $resultado1 = DB::table('comisiones')
    //         ->join('users', 'comisiones.user_id', '=', 'users.id')
    //         ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
    //         ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
    //         ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
    //         ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
    //         ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
    //         ->select(
    //             'contratos.id',
    //             'contratos.tipo_llamada',
    //             'contratos.created as fecha_de_venta',
    //             DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
    //             DB::raw('min(pagos.estatus) as estatus_pago'),
    //             DB::raw('min(pagos.segmento) as segmento_pago'),
    //             'pagos.id as pago_id',
    //             DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
    //             DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
    //             'convenios.empresa_nombre',
    //             'vendedor.title as vendedor',
    //             'comisiones.cliente_nombre',
    //             'comisiones.estatus',
    //             'comisiones.motivo_rechazo',
    //             'comisiones.modified',
    //             'comisiones.cantidad',
    //             'comisiones.campana_inicio',
    //             'comisiones.campana_fin',
    //             'contratos.user_id as user_id',
    //             'comisiones.id as comision_id',
    //             'contratos.tipo_pago'
    //         )
    //         ->whereNotIn('comisiones.estatus', ['Finiquitadas'])
    //         ->where('pagos.estatus', 'Pagado')
    //         ->whereIn('users.username', $this->ejecutivos_select)
    //         // ->whereNotIn('pagos.segmento', [0])
    //         ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
    //         ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'");

    //     $resultado2 = DB::table('comisiones')
    //         ->join('users', 'comisiones.user_id', '=', 'users.id')
    //         ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
    //         ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
    //         ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
    //         ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
    //         ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
    //         ->select(
    //             'contratos.id',
    //             'contratos.tipo_llamada',
    //             'contratos.created as fecha_de_venta',
    //             DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
    //             DB::raw('min(pagos.estatus) as estatus_pago'),
    //             DB::raw('min(pagos.segmento) as segmento_pago'),
    //             'pagos.id as pago_id',
    //             DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
    //             DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
    //             'convenios.empresa_nombre',
    //             'vendedor.title as vendedor',
    //             'comisiones.cliente_nombre',
    //             'comisiones.estatus',
    //             'comisiones.motivo_rechazo',
    //             'comisiones.modified',
    //             'comisiones.cantidad',
    //             'comisiones.campana_inicio',
    //             'comisiones.campana_fin',
    //             'contratos.user_id as user_id',
    //             'comisiones.id as comision_id',
    //             'contratos.tipo_pago'
    //         )
    //         ->whereNotIn('comisiones.estatus', [ 'Finiquitadas', 'Pagable'])
    //         ->whereIn('pagos.estatus', ['Rechazado'])
    //         ->whereIn('users.username', $this->ejecutivos_select)
    //         ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
    //         ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'");

    //     $this->datos_comisiones = DB::table('comisiones')
    //         ->join('users', 'comisiones.user_id', '=', 'users.id')
    //         ->leftJoin('salesgroups', 'users.salesgroup_id', '=', 'salesgroups.id')
    //         ->join('contratos', 'comisiones.contrato_id', '=', 'contratos.id')
    //         ->join('convenios', 'comisiones.convenio_id', '=', 'convenios.id')
    //         ->join('pagos', 'comisiones.contrato_id', '=', 'pagos.contrato_id')
    //         ->leftJoin('padres as vendedor', 'vendedor.id', '=', 'contratos.padre_id')
    //         ->select(
    //             'contratos.id',
    //             'contratos.tipo_llamada',
    //             'contratos.created as fecha_de_venta',
    //             DB::raw('min(pagos.fecha_de_pago) as primer_pago'),
    //             DB::raw('min(pagos.estatus) as estatus_pago'),
    //             DB::raw('min(pagos.segmento) as segmento_pago'),
    //             'pagos.id as pago_id',
    //             DB::raw("concat('[', upper(users.role), '] ', users.nombre, ' ', users.apellidos) as comisionista"),
    //             DB::raw("case when salesgroups.title is null then 'Sin asignación' else salesgroups.title end as equipo"),
    //             'convenios.empresa_nombre',
    //             'vendedor.title as vendedor',
    //             'comisiones.cliente_nombre',
    //             'comisiones.estatus',
    //             'comisiones.motivo_rechazo',
    //             'comisiones.modified',
    //             'comisiones.cantidad',
    //             'comisiones.campana_inicio',
    //             'comisiones.campana_fin',
    //             'contratos.user_id as user_id',
    //             'comisiones.id as comision_id',
    //             'contratos.tipo_pago'
    //         )
    //         ->whereNotIn('comisiones.estatus', ['Finiquitadas', 'Pagable', 'Pendiente', 'Pagada'])
    //         ->whereIn('pagos.estatus', ['Por Pagar'])
    //         ->whereIn('users.username', $this->ejecutivos_select)
    //         ->groupBy('contratos.id', 'contratos.created', 'users.role', 'users.nombre', 'users.apellidos', 'salesgroups.title')
    //         ->havingRaw("min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'")
    //         ->union($resultado1)
    //         ->union($resultado2)
    //         ->orderBy('comisionista')
    //         ->orderBy('empresa_nombre')
    //         ->paginate(20);

    // }


     /**
     * Autor: ISW. Diego Enrique Sanchez
     * Creado: 2022-11-07
     * Consulta de comisiones para los ejecutivos seleccionados
     * @param  [date] $fecha_inicio
     * @param  [date] $fecha_fin
     * @param  [array] $users
     * @return [array] $datos
     */
    public function getComisiones_()
    {
        $fechas = explode(' al ', $this->rango_fechas);
        $fecha_inicio = $fechas[0];
        $fecha_fin = $fechas[1];
        if ($this->ejecutivos_select) {
            $users = implode(',',  $this->ejecutivos_select);
        } 


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
                    and pagos.estatus IN ('Por Pagar')
                    and pagos.segmento not in (0)
                    and users.username in ({$users})

                group by contratos.id , contratos.created , users.role , users.nombre , users.apellidos , salesgroups.title, comisionista
                having min(pagos.fecha_de_pago) between '{$fecha_inicio}' and '{$fecha_fin}'
            order by comisionista , empresa_nombre");
        dd($datos);

    }

}
