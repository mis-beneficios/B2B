<?php

namespace App\Helpers;

use App\Contrato;
use App\Estancia;
use App\Pago;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use DateTime;
class PagosHelper
{
    public $pagos_por_contrato = 24;

    /**
     * Listado de pagos por contrato
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-08-29
     * @param  int $contrato_id
     * @return objeto Datatable
     */
    public function get_pagos_contrato($contrato_id = null)
    {
        $pagos = Pago::where('contrato_id', $contrato_id)
            ->where('cantidad', '!=', 0.00)
            ->get();

        return Datatables::of($pagos)
            ->editColumn('cantidad', function ($pagos) {
                return '$' . number_format($pagos->cantidad, 2) . ' ' . $pagos->contrato->divisa;
            })
            ->setRowClass(function ($pagos) {
                switch ($pagos->estatus) {
                    case 'Por Pagar':
                        $class = 'alert-warning';
                        break;
                    case 'Pagado':
                        $class = 'alert-info';
                        break;
                    default:
                        $class = 'alert-danger';
                        break;
                }
                return $class;
            })
            ->make(true);
    }

    /**
     * Seleccionador del metodo de calcular los pagos
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  int $contrato_id
     * @param  string $tipo
     * @param  date $fecha_de_inicio
     * @param  date $diaX
     * @param  date $diaY
     * @return array $pagos
     */
    public function calcular_pagos($contrato_id, $tipo, $fecha_de_inicio, $num_segmentos = null, $data_pago = null, $diaX = null, $diaY = null)
    {
        // dd($contrato_id, $tipo, $fecha_de_inicio, $num_segmentos, $data_pago);

        // dd($contrato_id, $tipo, $fecha_de_inicio, $num_segmentos);
        $pagos_por_contrato = $num_segmentos;
        $contratoData       = Contrato::findOrFail($contrato_id);
        switch ($tipo) {
            case 'semanal':
                return $this->calcular_semanalmente($contratoData, $pagos_por_contrato, $fecha_de_inicio, $data_pago);
                break;

            case 'catorcenal':
                return $this->calcular_catorcenalmente($contratoData, $pagos_por_contrato, $fecha_de_inicio, $data_pago);
                break;

            case 'quincenal_preciso':
                return $this->calcular_quincenalmente_estricto($contratoData, $pagos_por_contrato, $fecha_de_inicio, $diaX, $diaY);
                break;

            case 'quincenal_clasico':
                return $this->calcular_quincenalmente_clasico($contratoData, $pagos_por_contrato, $fecha_de_inicio, $data_pago);
                break;

            case 'mensual':
                return $this->calcular_mensualmente($contratoData, $pagos_por_contrato, $fecha_de_inicio, $data_pago);
                break;
        }
    }

    // public function get_data_recal($contratoData, $pagos_por_contrato, $fecha_de_inicio = null)
    // {

    // }



    /**
     * Calcular pagos quincenalmente cada 15 y 31 0 30 de cada mes
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  objeto $contratoData
     * @param  int $pagos_por_contrato
     * @param  date $fecha_primer_cobro
     * @return array $pagos
     */
    public function calcular_quincenalmente_clasico($contratoData, $pagos_por_contrato, $fecha_de_inicio = null, $data_pago = null) //codigo correcto
    {

      
        // Iteraciones para generar los segmentos
        $loop = intval($pagos_por_contrato);

        // Precio con el que se compro el paquete
        $precio_paquete     = $contratoData->precio_de_compra;

        // Cantidad por segmento
        $cantidad = round(($contratoData->precio_de_compra -  $data_pago['cantidad_pagada']) / $loop, 2);

        // Segmento desde el que se iniciara
        $inicio      = $data_pago['inicia_en_segmento'];


        $fecha_de_inicio          = Carbon::create($fecha_de_inicio);
        $sin_pendientes = false;

        $cont        = 0;
        $pagos       = [];
        // bandera para crear o no el enganche como segmento 0
        $crear_enganche = true;


        // $fecha_de_inicio = new DateTime($fecha_de_inicio);

        for ($i = 1; $i <= $loop; $i++) {
            if ($i == $inicio) {
                if ($contratoData->estancia->estancia_especial === 1 && $contratoData->num_segmentos() == 0 && $crear_enganche == true) {
                    $pagos[] = [
                        'contrato_id'    => $contratoData->contrato_id,
                        'segmento'       => 0,
                        'estatus'        => "Por Pagar",
                        'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                        'cantidad'       => $contratoData->estancia->enganche_especial,
                        'concepto'       => 'Enganche',
                    ];
                    // $i++;
                    $crear_enganche = false;
                }
            }
            $pagos[] = [
                'contrato_id'    => $contratoData->id,
                'segmento'       => $inicio,
                'estatus'        => "Por Pagar",
                'fecha_de_cobro' => $fecha_de_inicio->format('Y-m-d'),
                'cantidad'       => $cantidad,
                'concepto'       => '',
            ];

            $fecha_de_inicio->modify('+13 day');
            // Se suma 13 días debido a que la quincena de febrero normal, que es la más pequeña es de 13 días.
            if ($fecha_de_inicio->format('d') < '15') :
                while ($fecha_de_inicio->format('d') < '15') {
                    $fecha_de_inicio->modify('+1 day');
                }
            elseif ($fecha_de_inicio->format('d') > '15') :
                // Esta loop suma 1 dia cuando el resultado es mayor a 15, y mentras lo sea lo hará
                // terminará cuando deje de ser mayor el resultado, es decir, cuando llegue al dia
                // 1º del siguiente mes, por ello, al finalizar el loop, restará nuevamente 1 día
                // a la fecha.
                while ($fecha_de_inicio->format('d') > '15') {
                    $fecha_de_inicio->modify('+1 day');
                }
                $fecha_de_inicio->modify('-1 day');
            endif;
            $inicio++;
        }
        // dd(count($pagos));
        return $pagos;
    }



    /**
     * Calcular pagos semanales seleccionando un dia el cual se le cobrara
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  objeto $contratoData
     * @param  int $pagos_por_contrato
     * @param  date $fecha_de_inicio
     * @return array $pagos
     */
    public function calcular_semanalmente($contratoData, $pagos_por_contrato, $fecha_de_inicio, $data_pago = null) //codigo correcto
    {

        // Convertimos el valor a entero
        // Iteraciones para generar los segmentos
        $loop = intval($pagos_por_contrato);

        // Precio con el que se compro el paquete
        $precio_paquete     = $contratoData->precio_de_compra;

        // Cantidad por segmento
        $cantidad = round(($contratoData->precio_de_compra -  $data_pago['cantidad_pagada']) / $loop, 2);

        // Segmento desde el que se iniciara
        $inicio      = $data_pago['inicia_en_segmento'];


        $fecha_de_inicio          = Carbon::create($fecha_de_inicio);
        $sin_pendientes = false;

        $cont        = 0;
        $pagos       = [];

        $crear_enganche = true;

        for ($i = 1 ; $i <= $loop; $i++) {
            if ($i == $inicio) {
                if ($contratoData->estancia->estancia_especial === 1 && $contratoData->num_segmentos() == 0 && $crear_enganche == true) {
                    $pagos[] = [
                        'contrato_id'    => $contratoData->contrato_id,
                        'segmento'       => 0,
                        'estatus'        => "Por Pagar",
                        'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                        'cantidad'       => $contratoData->estancia->enganche_especial,
                        'concepto'       => 'Enganche',
                    ];

                    $crear_enganche = false;
                }
            }

            $pagos[] = [
                'contrato_id'    => $contratoData->id,
                'segmento'       => $inicio,
                'estatus'        => "Por Pagar",
                'fecha_de_cobro' => $fecha_de_inicio->format('Y-m-d'),
                'cantidad'       => $cantidad,
                'concepto'       => '',
            ];

            $fecha_de_inicio->addWeek();
            $inicio++;
        }
        return $pagos;
    }


    /**
     * Calcular pagos catorcenales, seleccionando fecha de cobro + 14 dias continuos
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  [objeto] $contratoData
     * @param  [int] $pagos_por_contrato
     * @param  [date] $fecha_de_inicio
     * @return [array] $pagos
     */
    public function calcular_catorcenalmente($contratoData, $pagos_por_contrato, $fecha_de_inicio, $data_pago = null) //Codigo correcto
    {
         // Iteraciones para generar los segmentos
        $loop = intval($pagos_por_contrato);

        // Precio con el que se compro el paquete
        $precio_paquete     = $contratoData->precio_de_compra;

        // Cantidad por segmento
        $cantidad = round(($contratoData->precio_de_compra -  $data_pago['cantidad_pagada']) / $loop, 2);

        // Segmento desde el que se iniciara
        $inicio      = $data_pago['inicia_en_segmento'];


        $fecha_de_inicio          = Carbon::create($fecha_de_inicio);
        $sin_pendientes = false;

        // dd($data_pago, $loop, $precio_paquete, $inicio);

        $cont        = 0;
        $pagos       = [];
        // bandera para crear o no el enganche como segmento 0
        $crear_enganche = true;

        for ($i = 1; $i <= $loop; $i++) {
            if ($i == $inicio) {
                if ($contratoData->estancia->estancia_especial === 1 && $contratoData->num_segmentos() == 0 && $crear_enganche == true) {
                    $pagos[] = [
                        'contrato_id'    => $contratoData->contrato_id,
                        'segmento'       => 0,
                        'estatus'        => "Por Pagar",
                        'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                        'cantidad'       => $contratoData->estancia->enganche_especial,
                        'concepto'       => 'Enganche',
                    ];
                    $crear_enganche = false;
                }

                // $fecha   = $fecha_de_inicio->format('Y-m-d');
                // $pagos[] = [
                //     'contrato_id'    => $contratoData->id,
                //     'segmento'       => $inicio,
                //     'estatus'        => "Por Pagar",
                //     'fecha_de_cobro' => $fecha,
                //     // 'cantidad'       => ($contratoData->precio_de_compra / $pagos_por_contrato),
                //     'cantidad'       => $cantidad,
                //     'concepto'       => 'entro al primer if',
                // ];
                // $i++;
            } 
            // else {

                // $pagos[] = [
                //     'contrato_id'    => $contratoData->id,
                //     'segmento'       => $inicio,
                //     'estatus'        => "Por Pagar",
                //     'fecha_de_cobro' => $fecha_de_inicio->modify('+14 day')->format('Y-m-d'),
                //     // 'cantidad'       => ($contratoData->precio_de_compra / $cuotas),
                //     'cantidad'       => $cantidad,
                //     'concepto'       => 'else',
                // ];
                $pagos[] = [
                    'contrato_id'    => $contratoData->id,
                    'segmento'       => $inicio,
                    'estatus'        => "Por Pagar",
                    'fecha_de_cobro' => $fecha_de_inicio->format('Y-m-d'),
                    // 'fecha_de_cobro' => $fecha_de_inicio->modify('+14 day')->format('Y-m-d'),
                    // 'cantidad'       => ($contratoData->precio_de_compra / $cuotas),
                    'cantidad'       => $cantidad,
                    'concepto'       => 'else',
                ];

                $fecha_de_inicio->modify('+14 day');
            // }
                $inicio++;
        }
         // dd($inicio);

        return $pagos;
    }

    /**
     * Calcular pagos mensualemente
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  [objeto] $contratoData
     * @param  [int] $pagos_por_contrato
     * @param  [date] $fecha_de_inicio
     * @return [array] $pagos
     */
    public function calcular_mensualmente($contratoData, $pagos_por_contrato, $fecha_de_inicio, $data_pago = null) //codigo correcto
    {

        // Iteraciones para generar los segmentos
        $loop = intval($pagos_por_contrato);

        // Precio con el que se compro el paquete
        $precio_paquete     = $contratoData->precio_de_compra;

        // Cantidad por segmento
        $cantidad = round(($contratoData->precio_de_compra -  $data_pago['cantidad_pagada']) / $loop, 2);

        // Segmento desde el que se iniciara
        $inicio      = $data_pago['inicia_en_segmento'];


        $fecha_de_inicio          = Carbon::create($fecha_de_inicio);
        $sin_pendientes = false;

        // dd($data_pago, $loop, $precio_paquete, $inicio, $pagos_por_contrato);

        $cont        = 0;
        $pagos       = [];
        // bandera para crear o no el enganche como segmento 0
        $crear_enganche = true;

        for ($i = 1; $i <= $loop; $i++) {
            if ($i == $inicio) {
                if ($contratoData->estancia->estancia_especial === 1 && $contratoData->num_segmentos() == 0 && $crear_enganche == true) {
                    $pagos[] = [
                        'contrato_id'    => $contratoData->contrato_id,
                        'segmento'       => 0,
                        'estatus'        => "Por Pagar",
                        'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                        'cantidad'       => $contratoData->estancia->enganche_especial,
                        'concepto'       => 'Enganche',
                    ];

                    $crear_enganche = false;
                }
            }

            $pagos[] = [
                'contrato_id'    => $contratoData->id,
                'segmento'       => $inicio,
                'estatus'        => "Por Pagar",
                'fecha_de_cobro' => $fecha_de_inicio->format('Y-m-d'),
                'cantidad'       => $cantidad,
                'concepto'       => '',
            ];

            $fecha_de_inicio->modify('+1 month');
            $inicio++;
            // }
        }

        return $pagos;
    }

    /**
     * Calcular pagos iniciando de la fecha inicial y calculando cada dia exactos datos por el usuario
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  [objeto] $contratoData
     * @param  [int] $pagos_por_contrato
     * @param  [date] $fecha_de_inicio
     * @param  [date] $diax
     * @param  [date] $diay
     * @return [array] $pagos
     */
    public function calcular_quincenalmente_estricto__($contratoData, $pagos_por_contrato, $fecha_de_inicio, $diax, $diay) //codigo correcto

    {

        // Convertimos el valor a entero
        $loop = intval($pagos_por_contrato);

        // Obtenemos los pagos realizados del contrato seleccionado y que el segmento sea diferente a cero por si se encuentra el pago de enganche se omita en el total pagado
        $pagos_contrato = Pago::where('contrato_id', $contratoData->id)->where('estatus', 'Pagado')->where('segmento', '!=' ,0);
        // Cantidad pagada
        $cantidad_pagada = $pagos_contrato->sum('cantidad');
        // Numero de pagos realizados exitosamente para restar a los pagos por contrato para realizar el calculo correctamente
        $pagos_realizados = $pagos_contrato->count();

        // obtenemos la cantidad que se debe pagar en cada segmento
        $cantidad = (($contratoData->precio_de_compra - $cantidad_pagada) / ($pagos_por_contrato - $pagos_realizados));

        // Primer pago que esta con esatus por pagar para iniciar desde ese punto el recalculo sin tomar los pagos ya realizados exitosamente
        $inicio_pago = Pago::where('contrato_id', $contratoData->id)->where('estatus', 'Por Pagar')
        ->where('segmento','>=' ,1)
        ->orderBy('id', 'ASC')->first();

        // En caso de que no exista ningun pago realizado se tomara como referencia el 1 para iniciar como indice o de lo contratio se tomara el segmento en el que se quedo el calculo anterior
        $inicio      = ($inicio_pago != null) ? $inicio_pago->segmento : 1;


        /**
         * Fecha de la cual se retomaran el recalculo de los segmentos
         */
        $fecha_de_inicio          = ($pagos_realizados == 0) ?  Carbon::create($fecha_de_inicio) : Carbon::create($inicio_pago->fecha_de_cobro);




        $cuotas = $pagos_por_contrato;
        $pagos  = [];

        // Ordenamos los días pasados al controlador,
        // para comenzar basándonos en cuentas de meses compltos.
        $dias = array(
            0 => $diax,
            1 => $diay,
        );

        sort($dias);

        for ($i = $inicio; $i <= $loop; $i++) {

            if ($i == $inicio) {
                /*
                se crea pago de enganche en caso de que la estancia sea especial y requiera enganche
                 */
                $pagos[] = [
                    'contrato_id'    => $contratoData->contrato_id,
                    'segmento'       => 0,
                    'estatus'        => "Por Pagar",
                    'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                    'cantidad'       => $contratoData->estancia->enganche_especial,
                    'concepto'       => 'Enganche',
                ];
                /**
                 * Old
                 */
                // if ($contratoData->estancia->estancia_especial === 1) {
                //     $pagos[] = [
                //         'contrato_id'    => $contratoData->contrato_id,
                //         'segmento'       => $i,
                //         'estatus'        => "Por Pagar",
                //         'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                //         'cantidad'       => $contratoData->estancia->enganche_especial,
                //     ];
                //     $i++;
                // }
            }

            $pagos[] = [
                'contrato_id'    => $contratoData->id,
                'segmento'       => $i,
                'estatus'        => "Por Pagar",
                'fecha_de_cobro' => $fecha_de_inicio->format('Y-m-d'),
                'cantidad'       => ($contratoData->precio_de_compra / $cuotas),
                'cuotas'         => $cuotas,
                'concepto'       => '',
            ];

            if ($fecha_de_inicio->format('d') < $dias[0]) {
                // Si esta en cierto dia menor al primer día de cobro del mes.
                $dif = $dias[0] - $fecha_de_inicio->format('d');
                $fecha_de_inicio->addDays($dif);
            } elseif ($fecha_de_inicio->format('d') > $dias[0] && $fecha_de_inicio->format('d') < $dias[1]) {
                // Si esta en cierto dia mayor al primer día de cobro del mes
                // y
                // Si está en cierto día menor al segundo dia de cobro del mes.
                $dif = $dias[1] - $fecha_de_inicio->format('d');
                $fecha_de_inicio->addDays($dif);
            } elseif ($fecha_de_inicio->format('d') > $dias[1]) {
                // Si está en cierto día mayo al segundo dia de cobro del mes.
                // Agregamos un mes
                $fecha_de_inicio->addMonth();

                // Mandamos al dia del primer cobro del mes.
                $fecha_de_inicio->setDate($fecha_de_inicio->format('Y'), $fecha_de_inicio->format('m'), $dias[0]);
            } elseif ($fecha_de_inicio->format('d') == $dias[0]) {
                // Si la fecha de inicio coincide con la primera fecha del mes

                // Mandamos en automático a la segunda fecha del mes
                $fecha_de_inicio->setDate($fecha_de_inicio->format('Y'), $fecha_de_inicio->format('m'), $dias[1]);
            } elseif ($fecha_de_inicio->format('d') == $dias[1]) {
                // Si concide perfecto con la segunda fecha del mese

                // Mandamos al siguiente mes
                $fecha_de_inicio->addMonth();

                // Establecemos el día del primer cobro de dicho mes.
                $fecha_de_inicio->setDate($fecha_de_inicio->format('Y'), $fecha_de_inicio->format('m'), $dias[0]);
            }
        }

        return $pagos;
    }

    /**
     * Calcular pagos iniciando de la fecha inicial y calculando cada dia exactos datos por el usuario
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  [objeto] $contratoData
     * @param  [int] $pagos_por_contrato
     * @param  [date] $fecha_de_inicio
     * @param  [date] $diax
     * @param  [date] $diay
     * @return [array] $pagos
     */
    public function calcular_quincenalmente_estricto($contratoData, $pagos_por_contrato, $fecha_de_inicio, $diax, $diay) //codigo correcto
    {

        // dd($contratoData, $pagos_por_contrato, $fecha_de_inicio, $diax, $diay);
        // Convertimos el valor a entero
        $loop = intval($pagos_por_contrato);

        $total_segmentos = Pago::where('contrato_id', $contratoData->id)->where('segmento', '!=' ,0)->count();
        // Obtenemos los pagos realizados del contrato seleccionado y que el segmento sea diferente a cero por si se encuentra el pago de enganche se omita en el total pagado
        $pagos_contrato = Pago::where('contrato_id', $contratoData->id)->where('estatus', 'Pagado')->where('segmento', '!=' ,0);

        //pagos pendientes
        $pagos_pendientes = Pago::where('contrato_id', $contratoData->id)->where('estatus', 'Por Pagar')->where('segmento', '!=' ,0)->count();

        //Pagos rechazados
        $pagos_rechazados = Pago::where('contrato_id', $contratoData->id)->whereIn('estatus', ['Rechazado','Cancelado'])->where('segmento', '!=' ,0)->count();
        // Cantidad pagada
        $cantidad_pagada = $pagos_contrato->sum('cantidad');
        // Numero de pagos realizados exitosamente para restar a los pagos por contrato para realizar el calculo correctamente
        $pagos_realizados = $pagos_contrato->count();

        // obtenemos la cantidad que se debe pagar en cada segmento
        $cantidad = (($contratoData->precio_de_compra - $cantidad_pagada) / ($pagos_por_contrato - $pagos_realizados));

        //Si los rechazados es distinto a 0, se sumaran los pagos rechazados para crear nuevos segmentos y cubrir la cantidad del paquete
        if ($pagos_rechazados != 0) {
            $loop = intval($pagos_por_contrato + $pagos_rechazados);
        }


        // Primer pago que esta con esatus por pagar para iniciar desde ese punto el recalculo sin tomar los pagos ya realizados exitosamente
        $inicio_pago = Pago::where('contrato_id', $contratoData->id)->where('estatus', 'Por Pagar')
        ->where('segmento','>=' ,1)
        ->orderBy('id', 'ASC')->first();


        $pago_enganche = Pago::where([
            'contrato_id'=> $contratoData->id,
            'concepto' => 'Enganche',
            'cantidad' => 200.0
        ])->count();


        // dd($pago_enganche);

        // En caso de que no exista ningun pago realizado se tomara como referencia el 1 para iniciar como indice o de lo contratio se tomara el segmento en el que se quedo el calculo anterior
        $inicio      = ($inicio_pago != null) ? $inicio_pago->segmento : 1;

        // $fecha_de_inicio          = ($pagos_realizados == 0 ) ?  Carbon::create($fecha_de_inicio) : Carbon::create($inicio_pago->fecha_de_cobro);
        $fecha_de_inicio          = Carbon::create($fecha_de_inicio);
        $sin_pendientes = false;


        if ($pagos_pendientes == 0 && $total_segmentos != 0) {
            $cantidad                 = (($contratoData->precio_de_compra - $cantidad_pagada) / $pagos_rechazados);
            $fecha_de_inicio          = Carbon::create($fecha_de_inicio);
            $inicio_pago              = Pago::where('contrato_id', $contratoData->id)->where('segmento','!=' , 0)->orderBy('id', 'DESC')->first();
            $inicio                   = $inicio_pago->segmento + 1;
            $loop                     = $inicio + $pagos_rechazados - 1;
            $sin_pendientes = true;
        }


        $cuotas = $pagos_por_contrato;
        $pagos  = [];

        // Ordenamos los días pasados al controlador,
        // para comenzar basándonos en cuentas de meses compltos.
        $dias = array(
            0 => $diax,
            1 => $diay,
        );

        sort($dias);

        for ($i = $inicio; $i <= $loop; $i++) {

            if ($i == $inicio && $pago_enganche == 0) {
                /*
                se crea pago de enganche en caso de que la estancia sea especial y requiera enganche
                 */
                $pagos[] = [
                    'contrato_id'    => $contratoData->contrato_id,
                    'segmento'       => 0,
                    'estatus'        => "Por Pagar",
                    'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                    'cantidad'       => $contratoData->estancia->enganche_especial?? config('app.enganche_mx'),
                    'concepto'       => 'Enganche',
                ];
                /**
                 * Old
                 */
                // if ($contratoData->estancia->estancia_especial === 1) {
                //     $pagos[] = [
                //         'contrato_id'    => $contratoData->contrato_id,
                //         'segmento'       => $i,
                //         'estatus'        => "Por Pagar",
                //         'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                //         'cantidad'       => $contratoData->estancia->enganche_especial,
                //     ];
                //     $i++;
                // }
            }

            $pagos[] = [
                'contrato_id'    => $contratoData->id,
                'segmento'       => $i,
                'estatus'        => "Por Pagar",
                'fecha_de_cobro' => $fecha_de_inicio->format('Y-m-d'),
                'cantidad'       => ($contratoData->precio_de_compra / $cuotas),
                'cuotas'         => $cuotas,
                'concepto'       => '',
            ];

            if ($fecha_de_inicio->format('d') < $dias[0]) {
                // Si esta en cierto dia menor al primer día de cobro del mes.
                $dif = $dias[0] - $fecha_de_inicio->format('d');
                $fecha_de_inicio->addDays($dif);
            } elseif ($fecha_de_inicio->format('d') > $dias[0] && $fecha_de_inicio->format('d') < $dias[1]) {
                // Si esta en cierto dia mayor al primer día de cobro del mes
                // y
                // Si está en cierto día menor al segundo dia de cobro del mes.
                $dif = $dias[1] - $fecha_de_inicio->format('d');
                $fecha_de_inicio->addDays($dif);
            } elseif ($fecha_de_inicio->format('d') > $dias[1]) {
                // Si está en cierto día mayo al segundo dia de cobro del mes.
                // Agregamos un mes
                $fecha_de_inicio->addMonth();

                // Mandamos al dia del primer cobro del mes.
                $fecha_de_inicio->setDate($fecha_de_inicio->format('Y'), $fecha_de_inicio->format('m'), $dias[0]);
            } elseif ($fecha_de_inicio->format('d') == $dias[0]) {
                // Si la fecha de inicio coincide con la primera fecha del mes

                // Mandamos en automático a la segunda fecha del mes
                $fecha_de_inicio->setDate($fecha_de_inicio->format('Y'), $fecha_de_inicio->format('m'), $dias[1]);
            } elseif ($fecha_de_inicio->format('d') == $dias[1]) {
                // Si concide perfecto con la segunda fecha del mese

                // Mandamos al siguiente mes
                $fecha_de_inicio->addMonth();

                // Establecemos el día del primer cobro de dicho mes.
                $fecha_de_inicio->setDate($fecha_de_inicio->format('Y'), $fecha_de_inicio->format('m'), $dias[0]);
            }
        }

        return $pagos;
    }

    /**
     * Creacion del primer cobro de enganche pagina USA
     * Autor: Isw. Diego  Enrique Sanchez Ordoñez
     * Creado: 2021-09-13
     * @param  objeto $contrato
     * @return objeto $pago
     */
    public function generar_pago_engache($contrato, $estatus = 'Por Pagar')
    {
        $fecha = Carbon::now();

        $pago                 = new Pago;
        $pago->contrato_id    = $contrato->id;
        $pago->tarjeta_id     = $contrato->tarjeta_id;
        $pago->segmento       = '0';
        $pago->estatus        = $estatus;
        $pago->concepto       = 'Enganche';
        $pago->cantidad       = ($contrato->estancia->enganche_especial != null) ? $contrato->estancia->enganche_especial : env('ENGANCHE');
        $pago->fecha_de_cobro = $fecha;
        $pago->fecha_de_pago  = ($estatus == 'Pagado') ? $fecha : null;
        $pago->created_by = 'Segmento generado automáticamente por sistema';
        $pago->save();
        return $pago;
    }

    //Generar pagos USA//

    /**
     * Calcular pagos quincenalmente cada 15 y 31 0 30 de cada mes
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  objeto $contratoData
     * @param  int $pagos_por_contrato
     * @param  date $fecha_primer_cobro
     * @return array $pagos
     */
    public function generar_pagos_quincenales($contrato_id, $pagos_por_contrato = 36, $fecha_primer_cobro = null)
    {

        $contratoData       = Contrato::findOrFail($contrato_id);
        $estancia           = Estancia::findOrFail($contratoData->estancia_id);
        $pagos_por_contrato = $estancia->cuotas;

        if (!empty($fecha_primer_cobro) || isset($fecha_primer_cobro)) {
            $dt = Carbon::create($fecha_primer_cobro);
        } else {
            $dt = Carbon::now();
            if (date('d') <= 10) {
                $fecha_primer_cobro = $dt->startOfMonth()->add(14, 'days')->format('Y-m-d');
            } else {
                $fecha_primer_cobro = $dt->endOfMonth()->format('Y-m-d');
            }
        }

        $cont  = 0;
        $pagos = [];

        for ($i = 1; $i <= $pagos_por_contrato; $i++) {
            if ($i == 1) {
                if ($dt->format('d') <= 15) {
                    $fecha = $dt->format('Y-m-d');
                    Pago::create([
                        'contrato_id'    => $contrato_id,
                        'segmento'       => $i,
                        'estatus'        => "Por Pagar",
                        'fecha_de_cobro' => $fecha,
                        'cantidad'       => ($contratoData->precio_de_compra / $pagos_por_contrato),
                        'concepto'       => '',
                    ]);
                    $i++;
                }
            }
            if ($cont == 1) {
                $fecha = $dt->startOfMonth()->add(14, 'days')->format('Y-m-d');
                $cont  = 2;
            } else {
                $fecha = $dt->endOfMonth()->format('Y-m-d');
                $cont  = 1;
            }

            if ($dt->format('d') >= 30 || $dt->format('d') <= 31) {
                $dt = $dt->addDay(2);
            } else {
                $dt = $dt->addMonth();
            }

            Pago::create([
                'contrato_id'    => $contrato_id,
                'segmento'       => $i,
                'estatus'        => "Por Pagar",
                'fecha_de_cobro' => $fecha,
                'cantidad'       => ($contratoData->precio_de_compra / $pagos_por_contrato),
                'concepto'       => '',
            ]);
        }

        return true;
    }
    /**
     * Calcular pagos mensualemente
     * Autor: Isw. Diego Enrique Sanchez
     * Creado: 2021-09-16
     * @param  [objeto] $contratoData
     * @param  [int] $pagos_por_contrato
     * @param  [date] $fecha_de_inicio
     * @return [array] $pagos
     */
    public function generar_pagos_mensual($contrato_id, $fecha_de_inicio = null, $pagos_por_contrato = 12) //codigo correcto

    {

        $contratoData = Contrato::findOrFail($contrato_id);
        if (!empty($fecha_de_inicio) || isset($fecha_de_inicio)) {
            $dt = Carbon::create($fecha_de_inicio);
        } else {
            $dt = Carbon::now();
            // if (date('d') <= 10) {
            //     $fecha_de_inicio = $dt->startOfMonth()->add(14, 'days')->format('Y-m-d');
            // } else {
            $fecha_de_inicio = $dt;
            // }
        }

        $inicio_pago = Pago::where('contrato_id', $contratoData->id)->where('estatus', 'Por Pagar')->orderBy('id', 'ASC')->first();
        $inicio      = ($inicio_pago != null) ? ($inicio_pago->segmento == 0 ? $inicio_pago->segmento + 1 : 0) : 1;

        // $fecha_de_inicio = Carbon::create($fecha_de_inicio);
        $cuotas = $pagos_por_contrato;
        $pagos  = [];

        for ($i = 1; $i <= $pagos_por_contrato; $i++) {

            if ($i == 1) {
                // if ($contratoData->estancia->estancia_especial === 1) {
                //     Pago::create([
                //         'contrato_id'    => $contrato_id,
                //         'segmento'       => $i,
                //         'estatus'        => "Por Pagar",
                //         'fecha_de_cobro' => Carbon::now()->format('Y-m-d'),
                //         'cantidad'       => ($contratoData->precio_de_compra / $pagos_por_contrato),
                //     ]);
                //     $i++;
                // }

                Pago::create([
                    'contrato_id'    => $contrato_id,
                    'segmento'       => $i,
                    'estatus'        => "Por Pagar",
                    'fecha_de_cobro' => $fecha_de_inicio->format('Y-m-d'),
                    'cantidad'       => ($contratoData->precio_de_compra / $pagos_por_contrato),
                    'concepto'       => '',
                ]);
                // $i++;
            } else {

                Pago::create([
                    'contrato_id'    => $contrato_id,
                    'segmento'       => $i,
                    'estatus'        => "Por Pagar",
                    'fecha_de_cobro' => $fecha_de_inicio->addMonth()->format('Y-m-d'),
                    'cantidad'       => ($contratoData->precio_de_compra / $pagos_por_contrato),
                    'concepto'       => '',
                ]);
            }

        }

        return $pagos;
    }


    /**
     * Creacion del primer cobro de enganche pagina USA
     * Autor: Isw. Diego  Enrique Sanchez Ordoñez
     * Creado: 2021-09-13
     * @param  objeto $contrato
     * @return objeto $pago
     */
    public function cobro_pago_engache($contrato, $estatus)
    {
        $fecha = Carbon::now();

        $pago                 = new Pago;
        $pago->contrato_id    = $contrato->id;
        $pago->tarjeta_id     = $contrato->tarjeta_id;
        $pago->segmento       = '0';
        $pago->estatus        = $estatus;
        $pago->cantidad       = ($contrato->estancia->enganche_especial != null) ? $contrato->estancia->enganche_especial : env('ENGANCHE');
        $pago->fecha_de_cobro = $fecha;
        $pago->fecha_de_pago  = ($estatus == 'Pagado') ? $fecha : null;
        $pago->created_by     = 'Cobro automatico Payment System';
        $pago->concepto       = 'Enganche';
        $pago->save();
        return $pago;
    }

}
