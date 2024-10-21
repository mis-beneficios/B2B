<?php

namespace App\Traits;

use App\Pago;
use App\Contrato;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

trait TerminalTrait
{

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-04-03
     * Obtenemos los pagos para pintarlos en la terminal query
     */
    public function get_data_terminal($request)
    {
        set_time_limit(4600);
        ini_set('MEMORY_LIMIT', '512M');


        $estatus = [];
        if (isset($request->pagosRechazados)) $estatus[] = 'Rechazado';
        if (isset($request->pagosPagados)) $estatus[] = 'Pagado';
        if (isset($request->pagosPendientes)) $estatus[] = 'Por Pagar';
        if (isset($request->pagosAnomalías)) $estatus[] = 'Anomalia';


        // $divisa = () ? 'USD' : 'MXN';

        $data = DB::table('pagos as p')
            ->join('contratos as con', 'p.contrato_id', '=', 'con.id')
            ->join('users as u', 'con.user_id', '=', 'u.id')
            ->join('convenios as conv', 'u.convenio_id', '=', 'conv.id')
            // ->join('tarjetas as t','con.tarjeta_id', '=', 't.id')
            // ->join('bancos as b','t.banco_id', '=', 'b.id')
            ->select(
                'p.*',
                'con.id as contrato_id',
                'con.user_id',
                'con.tarjeta_id',
                'con.via_serfin',
                'con.pago_con_nomina',
                'con.estatus as estatus_contrato',
                'con.convenio_id',
                'con.precio_de_compra',
                'con.sys_key',
                'con.divisa',
                DB::raw('concat(u.nombre, " ", u.apellidos) as cliente'),
                'con.precio_de_compra',
                'conv.empresa_nombre',
                'u.id as user_id',
                'con.tarjeta_id as tarjeta_id'
                // 't.numero as tarjeta_numero', DB::raw('concat(t.mes,"/",t.ano) as tarjeta_vencimiento'),
                // 'b.title as banco_title'

            );
        $data->whereIn('con.estatus', ['viajado', 'comprado', 'Comprado'])->where('p.cantidad', '>', 0);

        if (isset($request->cobro_int)) {
            $data->where('con.divisa', 'USD');
        } else {
            $data->where(function ($query) use ($request) {

                if (isset($request->nomina) && isset($request->terminal) && !isset($request->viaserfin)) {
                    // $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 0]);
                    $query->where('con.pago_con_nomina', 1)->orwhere('con.via_serfin', 0);
                } elseif (isset($request->nomina) && !isset($request->terminal) && isset($request->viaserfin)) {
                    // $data->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 1]);
                    $query->where('con.pago_con_nomina', 1)->orWhere('con.via_serfin', 1);
                } elseif (isset($request->nomina) && !isset($request->terminal) && !isset($request->viaserfin)) {
                    $query->where('con.pago_con_nomina', 1);
                } elseif (!isset($request->nomina) && !isset($request->terminal) && isset($request->viaserfin)) {
                    $query->where('con.via_serfin', 1)->where('con.sys_key', '<>', null);
                } elseif (!isset($request->nomina) && isset($request->terminal) && !isset($request->viaserfin)) {
                    $query->where(['con.pago_con_nomina' => 0, 'con.via_serfin' => 0]);
                } elseif (!isset($request->nomina) && isset($request->terminal) && isset($request->viaserfin)) {
                    $query->where('con.pago_con_nomina', 0);
                } elseif (!isset($request->nomina) && !isset($request->terminal) && !isset($request->viaserfin)) {
                    $query->where(['con.pago_con_nomina' => 1, 'con.via_serfin' => 1]);
                }
            })->where('con.divisa', '!=', 'USD');
        }
        if (!empty($estatus)) {
            $data->whereIn('p.estatus', $estatus);
        }

        if ($request->convenio_id) {
            $data->whereIn('conv.id', $request->convenio_id);
        }
        if ($request->paise_id) {
            $data->where('conv.paise_id', $request->paise_id);
        }
        $data->whereBetween('p.fecha_de_cobro', [$request->fecha_inicio, $request->fecha_fin]);

        // Obtener los resultados como colección
        return $data->get();

        // Implementar paginación manual
        // $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Página actual
        // $perPage = 100; // Número de elementos por página
        // $currentItems = $dataCollection->slice(($currentPage - 1) * $perPage, $perPage)->values(); // Slice de la colección
        // $paginatedData = new LengthAwarePaginator($currentItems, $dataCollection->count(), $perPage, $currentPage, [
        //     'path' => LengthAwarePaginator::resolveCurrentPath(),
        //     'query' => $request->query(), // Para mantener los parámetros de la URL
        // ]);
        // return $paginatedData;

        // $res = $data->limit(10)->get();

        // return $res;
    }

    public function contratos_nuevos()
    {
        $contratos = Contrato::with('cliente')
            ->whereHas('tarjeta.r_banco', function ($q) {
                $q->where('paise_id', config('app.pais_id'))->where('ignorar_en_via_serfin', 0);
            })
            ->whereHas('convenio', function ($q) {
                $q->where('paise_id', config('app.pais_id'));
            })
            ->where([
                'via_serfin' => 1,
            ])
            ->whereNotIn('estatus', ['Suspendido', 'Pagado', 'Cancelado'])
            ->where('sys_key', null)
            ->whereNotNull('user_id')
            ->whereNotNull('convenio_id')
            ->whereNotNull('tarjeta_id')
            ->Orwhere('sys_key', '');

        return $contratos;
    }

    public function drop_table()
    {
        $table = DB::statement('DROP TABLE IF EXISTS pagos_temp,pagos_temp2, pagos_temp3, pagos_temp4, pagos_temp5, pagos_temp6');

        return $table;
    }

    public function create_table_temp()
    {
        $table = DB::statement('CREATE TABLE pagos_temp
                                SELECT pagos.contrato_id, MAX(if(pagos.cantidad>0 AND pagos.estatus="Pagado",pagos.fecha_de_pago,0) ) AS ult_fecha_de_pago, SUM(if(pagos.cantidad>0,1,0)) AS cobros, SUM(if(pagos.cantidad>0 AND pagos.estatus="Pagado",1,0)) AS concretados, SUM(if(pagos.cantidad>0 AND pagos.estatus="Pagado",pagos.cantidad,0)) AS concretados_monto, SUM(if(pagos.estatus="Por Pagar" AND pagos.cantidad>0,1,0)) AS pendientes, SUM(if(pagos.cantidad>0 AND pagos.estatus="Por Pagar",pagos.cantidad,0)) AS pendientes_monto, SUM(if(pagos.cantidad>0 AND pagos.estatus="Rechazado",1,0)) AS rechazados, SUM(if(pagos.cantidad>0 AND pagos.estatus="Rechazado",pagos.cantidad,0)) AS rechazados_monto, SUM(if(pagos.cantidad>0 AND pagos.segmento=0 AND pagos.estatus="Por Pagar" || pagos.estatus="Rechazado" ,1,0)) AS segmentos_cero, SUM(if(pagos.cantidad>0 AND pagos.segmento=0 AND pagos.estatus="Por Pagar",1,0)) AS segmentos_cero_por_pagar, SUM(if(pagos.cantidad>0 AND segmento=0 AND pagos.estatus="Por Pagar",pagos.cantidad,0)) AS segmentos_cero_por_pagar_monto, SUM(if(pagos.cantidad>0 AND pagos.segmento=0 AND pagos.estatus="Rechazado",1,0)) AS segmentos_cero_rechazado, SUM(if(pagos.cantidad>0 AND pagos.segmento=0 AND pagos.estatus="Rechazado",pagos.cantidad,0)) AS segmentos_cero_rechazado_monto
                                FROM pagos
                                GROUP BY contrato_id
                                ORDER BY contrato_id ASC;');

        return $table;
    }

    public function create_table_temp2()
    {
        $table = DB::statement('CREATE TABLE pagos_temp2
                                SELECT
                                Contrato.user_id,
                                Contrato.tarjeta_id,
                                Contrato.convenio_id,
                                Contrato.sys_key,
                                Contrato.estatus,
                                Contrato.precio_de_compra AS precio_de_compra,
                                pagos_temp.*
                                FROM pagos_temp
                                LEFT JOIN
                                contratos AS Contrato ON (Contrato.id = pagos_temp.contrato_id)');

        return $table;
    }

    public function create_table_temp3()
    {
        $table = DB::statement("CREATE TABLE pagos_temp3
                                SELECT
                                CONCAT('',User.nombre,', ', IF(User.apellidos is null, '', User.apellidos)) as 'nombre_completo',
                                pagos_temp2.*
                                FROM pagos_temp2
                                LEFT JOIN
                                users AS User ON (pagos_temp2.user_id = User.id)");

        return $table;
    }

    public function create_table_temp4()
    {
        $table = DB::statement("CREATE TABLE pagos_temp4
                                SELECT
                                Tarjeta.tipo,
                                Tarjeta.banco_id,
                                pagos_temp3.*
                                FROM pagos_temp3
                                LEFT JOIN
                                tarjetas AS Tarjeta ON (pagos_temp3.tarjeta_id = Tarjeta.id)");

        return $table;
    }

    public function create_table_temp5()
    {
        $table = DB::statement("CREATE TABLE pagos_temp5
                                SELECT
                                Banco.title,
                                Banco.paise_id,
                                pagos_temp4.*
                                FROM pagos_temp4
                                LEFT JOIN
                                bancos AS Banco ON (pagos_temp4.banco_id = Banco.id)");

        return $table;
    }
    public function create_table_temp6()
    {
        $table = DB::statement("CREATE TABLE pagos_temp6
                                SELECT
                                Convenio.empresa_nombre,
                                pagos_temp5.*
                                FROM pagos_temp5
                                LEFT JOIN
                                convenios AS Convenio ON (Convenio.id = pagos_temp5.convenio_id)");

        return $table;
    }

    public function obtener_filtrado_cero($cantidad)
    {
        $data = DB::select("SELECT t.estatus, t.sys_key, concat(u.nombre, ' ', u.apellidos) as nombre_cliente, t.nombre_completo, CONCAT(' ', LPAD(tar.numero, 20,'0'),' ') AS tarjeta,
                                '{$cantidad}' AS monto,
                                t.title, b.clave, tar.estatus, t.ult_fecha_de_pago, LPAD(0,8,'0') AS pago_id,
                                CONCAT('', LPAD(tar.tipocuenta ,2,'0')) AS tipo_cuenta
                                FROM pagos_temp6 AS t
                                JOIN tarjetas AS tar ON t.tarjeta_id = tar.id
                                JOIN bancos AS b ON t.banco_id = b.id
                                join users as u on t.user_id = u.id
                                WHERE t.estatus NOT IN ('sin_aprobar', 'nuevo' , 'cancelado', 'Cancelado', 'pagado', 'suspendido')
                                AND t.convenio_id NOT IN (445)
                                AND t.convenio_id NOT IN (445)
                                AND t.paise_id = 1
                                AND t.segmentos_cero >0
                                AND t.concretados_monto < t.precio_de_compra
                                AND t.sys_key is not null
                                AND t.pendientes = 0");

        return $data;
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-03-24
     * Obtenemos todos los registros que se cobranran por serfin
     */
    public function filtrado_serfin_data($request)
    {

        $filtrado_serfin = DB::table('contratos as con');
        $filtrado_serfin->select(
            'con.estatus as es',
            DB::raw("concat(con.sys_key,'__', cast(p.id as char(10)),'_',cast(p.segmento as char(10))) as referencia_local"),
            DB::raw(" CONCAT('',`u`.`nombre`,', ',IF(`u`.`apellidos` is null, '', `u`.`apellidos`)) as 'usuario'"),
            't.name',
            DB::raw(" CONCAT('', LPAD(`t`.`numero`,20,'0')) AS 'tarjeta'"),
            'p.cantidad',
            'b.title',
            'b.clave',
            't.estatus',
            'p.fecha_de_cobro',
            DB::raw("(IF(con.importado, 'Importado', '')) AS 'importado'"),
            'p.id',
            DB::raw("CONCAT('', LPAD(`t`.`tipocuenta`,2,'0')) AS 'tipo_cuenta'")

        );
        $filtrado_serfin->join('pagos as p', 'con.id', '=', 'p.contrato_id');
        $filtrado_serfin->join('users as u', 'con.user_id', '=', 'u.id');
        $filtrado_serfin->join('tarjetas as t', 'con.tarjeta_id', '=', 't.id');
        $filtrado_serfin->join('bancos as b', 't.banco_id', '=', 'b.id');

        $filtrado_serfin->whereNotIn('con.estatus', ['sin_aprobar', 'nuevo', 'cancelado', 'Cancelado', 'pagado', 'suspendido']);
        $filtrado_serfin->where('p.cantidad', '>', '0');

        if ($request->select_banco != 'todo') {
            if ($request->select_banco == "sinBancomer") {
                $filtrado_serfin->whereNotIn('b.id', [13]);
            }
            if ($request->select_banco == "soloBancomer") {
                $filtrado_serfin->whereIn('b.id', [13]);
            }
        }

        if (isset($request->con_filtro)) {
            if ($request->condicion == 'solo') {
                $filtrado_serfin->where('p.segmento', $request->segmento);
            }
            if ($request->condicion == 'contenga') {
                $segs = explode(",", $request->segmento);
                $filtrado_serfin->whereIn('p.segmento', $segs);
            }
            if ($request->condicion == 'entre') {
                $segs = explode(",", $request->segmento);
                $filtrado_serfin->whereBetween('p.segmento', [$segs[0], $segs[1]]);
            }
        }

        if ($request->estatus_pago == 'por_pagar') {
            $filtrado_serfin->where('p.estatus', 'Por Pagar');
        } elseif ($request->estatus_pago == 'Rechazado') {
            $filtrado_serfin->where('p.estatus', 'Rechazado');
        } elseif ($request->estatus_pago == 'Pagado') {
            $filtrado_serfin->where('p.estatus', 'Pagado');
        }

        $filtrado_serfin->where('con.convenio_id', '!=', 445);
        $filtrado_serfin->where('b.paise_id', '=', 1);
        $filtrado_serfin->where('con.via_serfin', '=', 1);
        $filtrado_serfin->where('sys_key', '!=', null);

        $filtrado_serfin->where('p.fecha_de_cobro', '>=', $request->fecha_inicio);
        $filtrado_serfin->where('p.fecha_de_cobro', '<=', $request->fecha_fin);
        $filtrado_serfin->orderBy('con.sys_key');

        $res = $filtrado_serfin->get();

        return $res;
    }


    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-27
     * Obtenemos todos los registros que se cobranran por serfin
     */
    public function filtrado_suspendidos_data_old($request)
    {

        $filtrado_suspendidos = DB::table('contratos as con');
        $filtrado_suspendidos->select(
            'con.estatus as es',
            DB::raw("concat(con.sys_key,'__', cast(p.id as char(10)),'_',cast(p.segmento as char(10))) as referencia_local"),
            DB::raw(" CONCAT('',`u`.`nombre`,', ',IF(`u`.`apellidos` is null, '', `u`.`apellidos`)) as 'usuario'"),
            't.name',
            DB::raw(" CONCAT('', LPAD(`t`.`numero`,20,'0')) AS 'tarjeta'"),
            DB::raw("'{$request->cantidad_sus}' AS cantidad"),
            'b.title',
            'b.clave',
            't.estatus',
            'p.fecha_de_cobro',
            DB::raw("(IF(con.importado, 'Importado', '')) AS 'importado'"),
            'p.id',
            DB::raw("CONCAT('', LPAD(`t`.`tipocuenta`,2,'0')) AS 'tipo_cuenta'"),
            DB::raw("SUM(CASE WHEN p.estatus='Pagado' THEN 1 ELSE 0 END) AS pagos_realizados"),
            DB::raw("SUM(p.cantidad) AS total_pagado"),
            DB::raw("con.precio_de_compra  AS precio_de_compra")
        );

        $filtrado_suspendidos->join('pagos as p', 'con.id', '=', 'p.contrato_id');
        $filtrado_suspendidos->join('users as u', 'con.user_id', '=', 'u.id');
        $filtrado_suspendidos->join('convenios as c', 'con.convenio_id', '=', 'c.id');
        $filtrado_suspendidos->join('tarjetas as t', 'con.tarjeta_id', '=', 't.id');
        $filtrado_suspendidos->join('bancos as b', 't.banco_id', '=', 'b.id');

        $filtrado_suspendidos->whereBetween('con.created', [$request->fecha_inicio_suspendido, $request->fecha_fin_suspendido]);
        $filtrado_suspendidos->whereIn('con.estatus', ['suspendido']);


        $filtrado_suspendidos->whereIn('p.estatus', ['Pagado']);
        $filtrado_suspendidos->where('p.cantidad', '>', '0');

        $filtrado_suspendidos->where('con.convenio_id', '!=', 445);
        $filtrado_suspendidos->where('c.paise_id', 1);

        $filtrado_suspendidos->where('con.via_serfin', 1);
        $filtrado_suspendidos->whereNotNull('con.sys_key');



        // $filtrado_suspendidos->where('b.paise_id', 1);

        // $filtrado_suspendidos->where('con.created', '>=', $request->fecha_inicio_suspendido);
        // $filtrado_suspendidos->where('con.created', '<=', $request->fecha_fin_suspendido);

        $filtrado_suspendidos->groupBy('con.sys_key');
        $filtrado_suspendidos->havingRaw("total_pagado < precio_de_compra");
        $res = $filtrado_suspendidos->get();

        return $res;
    }
    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-27
     * Obtenemos todos los registros que se cobranran por serfin
     */
    public function filtrado_suspendidos_data($request)
    {

        $filtrado_suspendidos = DB::select("SELECT 
                                            c.estatus as es,
                                            c.sys_key as referencia_local,
                                            CONCAT('', u.nombre,' ',IF(u.apellidos is NULL, '', u.apellidos)) as usuario,
                                            t.name,
                                            CONCAT('', LPAD(t.numero,20,'0')) AS tarjeta,   
                                            -- p.cantidad AS cantidad,
                                            '{$request->cantidad_sus}' AS cantidad,
                                            b.title,
                                            b.clave,
                                            t.estatus,
                                            p.fecha_de_cobro,
                                            (IF(c.importado, 'Importado', '')) AS importado,
                                            p.id,
                                            CONCAT('', LPAD(t.tipocuenta,2,'0')) AS tipo_cuenta,
                                            SUM(CASE WHEN p.estatus='Pagado' THEN 1 ELSE 0 END) AS pagos_realizados,
                                            SUM(p.cantidad) AS total_pagado,
                                            c.precio_de_compra  AS precio_de_compra
                                            FROM contratos c 
                                            JOIN users u ON c.user_id = u.id
                                            JOIN convenios con ON c.convenio_id = con.id
                                            JOIN pagos p ON p.contrato_id = c.id
                                            Join tarjetas AS t ON (c.tarjeta_id = t.id)
                                            LEFT JOIN bancos AS b ON (t.banco_id = b.id)
                                            WHERE p.estatus IN ('Pagado')  
                                            AND p.cantidad > 0
                                            AND c.convenio_id not in(445)
                                            AND u.convenio_id not in(445)
                                            AND c.created between '{$request->fecha_inicio_suspendido}' and '{$request->fecha_fin_suspendido}'
                                            AND c.via_serfin = 1
                                            AND c.sys_key IS NOT null
                                            AND con.paise_id = 1
                                            AND c.estatus IN ('suspendido')
                                            GROUP BY c.sys_key
                                            HAVING (total_pagado < precio_de_compra)");


        return $filtrado_suspendidos;
    }
    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-03-24
     * Obtenemos los contratos que se pueden cobrar con doble referencia dependiendo de las fechas que se ingresen y si se cubren ambas referencias en ese periodo de fechas ingresadas
     */
    public function get_filtrado_doble($request)
    {
        $segmento1 = $request->segmento_1;
        $segmento2 = $request->segmento_2;
        $bancos    = $request->banco;
        $desde     = $request->desde;
        $hasta     = $request->hasta;

        $query     = DB::table('contratos')
            ->select(
                'contratos.estatus',
                DB::raw("CONCAT('', contratos.sys_key, '__', GROUP_CONCAT(CONCAT(pagos.id,'_',pagos.segmento) ORDER BY pagos.segmento SEPARATOR '__')) as referencia"),
                DB::raw("UPPER(CONCAT(TRIM(users.nombre),' ',IF(users.apellidos IS NULL,' ', TRIM(users.apellidos)))) as usuario"),
                DB::raw("UPPER(CONCAT(TRIM(users.nombre),' ',IF(users.apellidos IS NULL,' ', TRIM(users.apellidos)))) as usuario2"),
                DB::raw("CONCAT('', LPAD(tarjetas.numero,20,'0')) as tarjeta"),
                DB::raw("SUM(pagos.cantidad) as monto_total"),
                'bancos.title',
                'bancos.clave',
                'tarjetas.estatus',
                DB::raw("DATE_FORMAT(pagos.fecha_de_cobro, '%d/%m/%Y') as fecha_de_cobro"),
                'pagos.id',
                DB::raw("CONCAT('', LPAD(tarjetas.tipocuenta,2,'0')) as tipo_de_cuenta"),
                DB::raw("TRIM(users.username) as correo"),
                DB::raw("COUNT(pagos.id) AS num_segmentos")
            )
            ->join('pagos', 'contratos.id', '=', 'pagos.contrato_id')
            ->join('users', 'contratos.user_id', '=', 'users.id')
            ->join('tarjetas', 'contratos.tarjeta_id', '=', 'tarjetas.id')
            ->join('bancos', 'tarjetas.banco_id', '=', 'bancos.id')
            ->whereIn('pagos.fecha_de_cobro', [$desde, $hasta])
            ->whereIn('pagos.estatus', ['Por Pagar'])
            ->whereBetween('pagos.segmento', [$segmento1, $segmento2])
            ->where('pagos.cantidad', '>', '0')
            ->whereNotIn('contratos.estatus', ['sin_aprobar', 'nuevo', 'cancelado', 'Cancelado', 'pagado', 'suspendido'])
            ->where('contratos.sys_key', '!=', 'NULL')
            ->whereNotIn('contratos.convenio_id', ['455'])
            ->where('contratos.via_serfin', '1')
            ->whereNotIn('users.convenio_id', ['455'])
            ->where('bancos.paise_id', '1')
            ->when($request->banco == 'sin_bancomer', function ($q) {
                return $q->whereNotIn('bancos.id', [13]);
            })
            ->groupBy('contratos.id')
            ->orderBy('pagos.id', 'ASC')
            // ->limit(20)
            ->get();

        return $query;
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-03-23
     * Obtenemos el filtrado de los clientes para enviar el correo masivo de notificacion por cobranza doble
     */
    public function get_filtrado_clientes($request)
    {

        $segmento1 = $request->segmento_1;
        $segmento2 = $request->segmento_2;
        $bancos    = $request->banco;
        $desde     = $request->desde;
        $hasta     = $request->hasta;
        $query     = DB::table('contratos')
            ->select(
                'contratos.id',
                DB::raw("UPPER(CONCAT(TRIM(users.nombre),' ',IF(users.apellidos IS NULL,' ', TRIM(users.apellidos)))) as usuario"),
                DB::raw("TRIM(users.username) as correo"),
                DB::raw("COUNT(pagos.id) AS num_segmentos")
            )
            ->join('pagos', 'contratos.id', '=', 'pagos.contrato_id')
            ->join('users', 'contratos.user_id', '=', 'users.id')
            ->join('tarjetas', 'contratos.tarjeta_id', '=', 'tarjetas.id')
            ->join('bancos', 'tarjetas.banco_id', '=', 'bancos.id')
            ->whereIn('pagos.fecha_de_cobro', [$desde, $hasta])
            ->whereIn('pagos.estatus', ['Por Pagar'])
            ->whereBetween('pagos.segmento', [$segmento1, $segmento2])
            ->where('pagos.cantidad', '>', '0')
            ->whereNotIn('contratos.estatus', ['sin_aprobar', 'nuevo', 'cancelado', 'Cancelado', 'pagado', 'suspendido'])
            ->where('contratos.sys_key', '!=', 'NULL')
            ->whereNotIn('contratos.convenio_id', ['455'])
            ->where('contratos.via_serfin', '1')
            ->whereNotIn('users.convenio_id', ['455'])
            ->where('bancos.paise_id', '1')
            ->when($request->banco == 'sin_bancomer', function ($q) {
                return $q->whereNotIn('bancos.id', [13]);
            })
            ->groupBy('contratos.user_id')
            ->when($request->cliente == 'dobles', function ($q) {
                return $q->having('num_segmentos', '>=', 2);
            })
            ->orderBy('pagos.id', 'ASC')
            // ->limit(20)
            ->get();

        // dd($query);
        return $query;

        /**
         * Old
         */
        // $segmento1 = $request->segmento_1;
        // $segmento2 = $request->segmento_2;
        // $bancos    = $request->banco;
        // $desde     = $request->desde;
        // $hasta     = $request->hasta;
        // $cliente   = ($request->cliente == 'dobles') ? 2 : 1;
        // $query     = DB::table('contratos')
        //     ->select(
        //         'contratos.id',
        //         DB::raw("UPPER(CONCAT(TRIM(users.nombre),' ',IF(users.apellidos IS NULL,' ', TRIM(users.apellidos)))) as usuario"),
        //         DB::raw("TRIM(users.username) as correo"),
        //         DB::raw("COUNT(pagos.id) AS num_segmentos")
        //     )
        //     ->join('pagos', 'contratos.id', '=', 'pagos.contrato_id')
        //     ->join('users', 'contratos.user_id', '=', 'users.id')
        //     ->join('tarjetas', 'contratos.tarjeta_id', '=', 'tarjetas.id')
        //     ->join('bancos', 'tarjetas.banco_id', '=', 'bancos.id')
        //     ->whereNotIn('contratos.estatus', ['sin_aprobar', 'nuevo', 'cancelado', 'Cancelado', 'pagado', 'suspendido'])
        //     ->where('contratos.sys_key', '!=', 'NULL')
        //     ->whereNotIn('contratos.convenio_id', ['455'])
        //     ->where('contratos.via_serfin', '1')
        //     ->whereNotIn('users.convenio_id', ['455'])
        //     ->where('bancos.paise_id', '1')
        //     ->when($request->banco == 'sin_bancomer', function($q){
        //         return $q->whereNotIn('bancos.id', [13]);
        //     })
        //     ->whereBetween('pagos.segmento', [$segmento1, $segmento2])
        //     ->whereIn('pagos.estatus', ['por pagar', 'Por Pagar'])
        //     ->where('pagos.cantidad', '>', '0')
        //     ->whereIn('pagos.fecha_de_cobro', [$desde, $hasta])
        //     ->groupBy('users.username')
        //     ->when($request->cliente === 'dobles', function($q){
        //         $q->having('num_segmentos', '>=' ,2);
        //     })
        //     ->orderBy('pagos.id', 'ASC')
        //     ->get();
        // return $query;
    }


    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-03-24
     * Obtenemos todos loc ontratos que estan registrados en cobro por terminal
     */
    public function filtrado_terminal($request)
    {
        $segmento1    = $request->segmento_1_t;
        $segmento2    = $request->segmento_2_t;
        $desde        = $request->desde_t;
        $hasta        = $request->hasta_t;
        $estatus_pago = $request->estatus_pago;
        $query        = DB::table('contratos')
            ->select(
                'contratos.id',
                DB::raw("UPPER(CONCAT(TRIM(users.nombre),' ',IF(users.apellidos IS NULL,' ', TRIM(users.apellidos)))) as usuario"),
                DB::raw("TRIM(users.username) as correo"),
            )
            ->join('pagos', 'contratos.id', '=', 'pagos.contrato_id')
            ->join('users', 'contratos.user_id', '=', 'users.id')
            ->join('tarjetas', 'contratos.tarjeta_id', '=', 'tarjetas.id')
            ->join('bancos', 'tarjetas.banco_id', '=', 'bancos.id')
            ->whereIn('pagos.fecha_de_cobro', [$desde, $hasta])
            ->whereIn('pagos.estatus', $estatus_pago)
            ->whereBetween('pagos.segmento', [$segmento1, $segmento2])
            ->where('pagos.cantidad', '>', '0')
            ->whereNotIn('contratos.estatus', ['sin_aprobar', 'nuevo', 'cancelado', 'Cancelado', 'pagado', 'suspendido'])
            ->whereNotIn('contratos.convenio_id', ['455'])
            ->where('contratos.via_serfin', 0)
            ->where('contratos.pago_con_nomina', 0)
            ->whereNotIn('users.convenio_id', ['455'])
            ->where('bancos.paise_id', '1')
            //->groupBy('contratos.id')
            ->groupBy('users.id')
            ->orderBy('pagos.segmento', 'ASC')
            ->get();
        return $query;
    }

    /**
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-03-24
     * Obtenemos todos los registros que se cobranran por serfin
     */
    public function filtrado_bancomer_data($request)
    {
        $filtrado_serfin = DB::table('contratos as con');
        $filtrado_serfin->select(
            DB::raw("p.cantidad as importe"),
            DB::raw("REPLACE(CONVERT(p.cantidad, CHAR(10)), '.', '') as importe_2"),
            DB::raw("DATE_FORMAT(NOW(),'%Y%m%d') as fecha"),
            // DB::raw("Domiciliación de recibos as operacion"),
            DB::raw("DATE_FORMAT(NOW(),'%Y%m%d') as fecha2"),
            // 'BBVA BANCOMER as banco',
            DB::raw("if(t.tipocuenta = '03', 'Tarjeta de Debito/Crédito', 'Cuenta CLABE') as tipo"),
            // DB::raw("t.numero AS tarjeta"),
            // DB::raw("CONCAT('', CAST(t.numero as CHAR)) AS tarjeta"),
            DB::raw("CONCAT('', LPAD(t.numero,20,' ')) as tarjeta"),
            // DB::raw("CAST(CONCAT('', t.numero) as char(18)) AS tarjeta"),
            DB::raw("UCASE(SUBSTRING(t.name,1,40)) as nombre"),
            DB::raw("CONCAT('',con.sys_key,'x',CAST(p.id AS char(10) ),'x',CAST(p.segmento AS char(10) )) as 'referencia'"),
            DB::raw("UCASE(SUBSTRING(CONCAT('',TRIM(TRIM(TRIM(TRIM(u.nombre)))),' ',IF(u.apellidos is null, '', TRIM(TRIM(TRIM(TRIM(u.apellidos)))))),1,40)) as usuario"),
            // '000 as iva',
            'p.id as pago_id',
            DB::raw("CONCAT('',con.sys_key,'x',CAST(p.id AS char(10) ),'x',CAST(p.segmento AS char(10) )) as referencia2")
        );
        $filtrado_serfin->join('pagos as p', 'con.id', '=', 'p.contrato_id');
        $filtrado_serfin->join('users as u', 'con.user_id', '=', 'u.id');
        $filtrado_serfin->join('tarjetas as t', 'con.tarjeta_id', '=', 't.id');
        $filtrado_serfin->join('bancos as b', 't.banco_id', '=', 'b.id');

        $filtrado_serfin->whereNotIn('con.estatus', ['sin_aprobar', 'nuevo', 'cancelado', 'Cancelado', 'pagado', 'suspendido']);
        $filtrado_serfin->where('p.cantidad', '>', '0');
        $filtrado_serfin->whereIn('b.id', [13]);


        if ($request->condicion_bancomer == 'solo') {
            $filtrado_serfin->where('p.segmento', $request->segmento_bancomer);
        }
        if ($request->condicion_bancomer == 'contenga') {
            $segs = explode(",", $request->segmento_bancomer);

            $filtrado_serfin->whereIn('p.segmento', $segs);
        }
        if ($request->condicion_bancomer == 'entre') {
            $segs = explode(",", $request->segmento_bancomer);
            $filtrado_serfin->whereBetween('p.segmento', [$segs[0], $segs[1]]);
        }

        if ($request->condicion_bancomer == 'excep') {
            $filtrado_serfin->whereNotIn('p.segmento', [$request->segmento_bancomer]);
        }

        if ($request->condicion_bancomer == 'mayor') {
            $filtrado_serfin->where('p.segmento', '>=', $request->segmento_bancomer);
        }

        if ($request->estatus_pago_bancomer == 'por_pagar') {
            $filtrado_serfin->where('p.estatus', 'Por Pagar');
        } else {
            $filtrado_serfin->where('p.estatus', 'Rechazado');
        }

        $filtrado_serfin->where('con.convenio_id', '!=', 445);
        $filtrado_serfin->where('b.paise_id', '=', 1);
        $filtrado_serfin->where('con.via_serfin', '=', 1);
        $filtrado_serfin->where('con.sys_key', '!=', null);

        $filtrado_serfin->where('p.fecha_de_cobro', '>=', $request->fecha_inicio_bancomer);
        $filtrado_serfin->where('p.fecha_de_cobro', '<=', $request->fecha_fin_bancomer);
        $filtrado_serfin->orderBy('con.sys_key');

        $res = $filtrado_serfin->get();

        return $res;
    }
}
