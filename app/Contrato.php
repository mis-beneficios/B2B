<?php

namespace App;

use App\Pago;
use App\Comision;
use App\Serfinrespuestas;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\DB;
use Log;

class Contrato extends Model
{
    public function __construct()
    {
        setlocale(LC_ALL, 'es_ES');
    }
    protected $table   = 'contratos';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'convenio_id',
        'invitacion_id',
        'estancia_id',
        'tarjeta_id',
        'paquete',
        'estatus',
        'precio_de_compra',
        'pago_con_nomina',
        'pago_con_otras_tarjetas',
        'estatus_de_pagos',
        'padre_id',
        'noches',
        'adultos',
        'ninos',
        'juniors',
        'divisa',
        'created',
        'modified',
        'edad_max_ninos',
        'edad_max_juniors',
        'sys_key',
        'layout_processed',
        'via_serfin',
        'estatus_comisiones',
        'comisiones_actualizadas',
        'reservacion_en_proceso',
        'importado',
        'log',
        'pagos_log',
        'tipo_llamada',
        'usd_mxp',
        'autorizo',
        'agreeterms',
        'numero_de_empleado',
        'alerta_user_enviada',
        'alerta_compra',
        'alerta_compra_fecha',
        'alerta_compra_enviada_a',
        'fecha_primer_segmento',
        'fecha_primer_descuento_contrato',
        'pagos',
        'cantidad_pagos_hechos',
        'destino_hotel_id',
        'fecha_viaje',
        'fecha_viaje_salida',
        'motivo_cancelacion',
        'tipo_pago',
        'aplica_descuento',
        'log',
    ];

    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function estancia()
    {
        return $this->belongsTo(Estancia::class, 'estancia_id');
    }

    public function padre()
    {
        return $this->belongsTo(Padre::class);
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class, 'convenio_id');
    }

    public function pagos_contrato()
    {
        return $this->hasMany(Pago::class, 'contrato_id', 'id')->where('cantidad', '!=', 0)->orderBy('segmento', 'ASC');
    }

    public function cuotas_contrato()
    {
        return $this->hasMany(Pago::class, 'contrato_id', 'id')
            ->where('cantidad', '!=', 0)
            ->where('cantidad', '!=', '200.00')
            ->where('segmento', '!=', 0);
    }

    public function tarjeta()
    {
        return $this->belongsTo(Tarjeta::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'contrato_id', 'id');
    }


    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-05-03
     * Descripcion: Relacion muchos a muchos para contratos y reservaciones asociados
     */
    public function reservaciones()
    {
        return $this->belongsToMany(Reservacion::class,'contratos_reservaciones', 'contrato_id', 'reservacione_id');
    }

    // public function p_reservacion()
    // {
    //     return $this->belongsTo(ContratosReservaciones::class, 'contrato_id');
    // }
    //
    //
    public function r_reservacion()
    {
        return $this->belongsToMany(Reservacion::class, 'contratos_reservaciones', 'contrato_id', 'reservacione_id');
    }

    public function comision()
    {
        return $this->hasOne(Comision::class);
    }

    public function comisiones()
    {
        return $this->hasMany(Comision::class, 'contrato_id', 'id');
    }
    public function metodoPago()
    {
        if ($this->via_serfin == 1) {
            $metodo = 'Tarjeta credito/debito';
        } else if ($this->pago_con_nomina == 1) {
            $metodo = 'Nomina';
        } else if ($this->pago_con_nomina == 0 && $this->via_serfin == 0) {
            $metodo = 'Corbros por terminal';
        } else {
            $metodo = 'Sin definir';
        }

        return $metodo;
    }

    public function diffForhumans()
    {
        return Carbon::create($this->created)->diffForHumans();
    }

    public function creado()
    {
        return new Date($this->created);
    }

    public function tipo_plan()
    {
        $cadena  = strpos($this->estancia->title, 'EUROPEO');
        $cadena2 = strpos($this->estancia->title, 'TODO INCLUIDO');
        if ($cadena) {
            $res = 'EUROPEO';
        } else if ($cadena2) {
            $res = 'TODO INCLUIDO';
        } else {
            $res = '';
        }

        return $res;

    }

    public function tipo_temporada()
    {
        $cadena = strpos($this->estancia->title, 'ALTA');
        if ($cadena) {
            $res = 'ALTA'; /* 60 */
        } else if (strpos($this->estancia->title, 'BAJA')) {
            $res = 'BAJA'; /* 30 */
        } else {
            $res = "MEDIA"; /* 60 */
        }
        return $res;
    }

    public function color_estatus()
    {
        switch ($this->estatus) {
            case 'suspendido':
                $color = '#5C5C5C';
                break;
            case 'sin_aprobar':
                $color = '#53007D';
                break;
            case 'por_autorizar':
                $color = '#F59B00';
                break;
            case 'nuevo':
                $color = '#165e6c';
                break;
            case 'por_cancelar':
                $color = '#dc3545';
                break;
            case 'cancelado':
                $color = '#8E0000';
                break;
            case 'Tarjeta con problemas':
                $color = '#fd7e14';
                break;
            case 'viajado':
                $color = '#000';
                break;
            default:
                $color = '#007bff';
                break;
        }
        return $color;
    }

    public function pagos_concretados()
    {
        $pagos_concretados = Pago::where('contrato_id', $this->id)->where('estatus', 'Pagado')->count();
        return $pagos_concretados;
    }

    public function num_segmentos()
    {
        $num_segmentos = Pago::where('contrato_id', $this->id)->where('segmento', '!=', '0')->count();
        return $num_segmentos;
    }

    public function sum_pagos_concretados()
    {
        $pagos_concretados = Pago::where('contrato_id', $this->id)->where('estatus', 'Pagado')->sum('cantidad');
        return $pagos_concretados;
    }

    public function fecha_primer_descuento()
    {
        $pago = Pago::where(['contrato_id' => $this->id, 'segmento' => 1])->first();
        if ($pago) {
            $date = $pago->fecha_de_cobro;
        } else {
            $date = false;
        }

        return $date;
    }

    public function getLogContratoAttribute()
    {
        if ($this->log != null) {
            $log = '';
            if ($this->padre) {
                $log .= "\n \n#**" . $this->padre->vendedor->fullName . "**, [" . $this->padre->title . "]: \n";
                $log .= "### Fecha: **" . $this->created . "** \n";
                $log .= "## **" . 'Registrado' . "**: \n";
                $log .= "+ ****\n";
                $log .= "+ ** {$this->created} **\n\n";
                // $log .= "___________________________________ \n";
                $log .= "* * *  \n\n";
            }

            // dd($log);

            return Markdown::convertToHtml($this->log . $log); // <p>foo</p>
        } else {
            return '';
        }
    }

    public function metodo_de_pago()
    {
        if ($this->pago_con_nomina == 1 && $this->via_serfin == 0) {
            $metodo = 'nomina';
        } elseif ($this->pago_con_nomina == 0 && $this->via_serfin == 0) {
            $metodo = 'terminal';
        } elseif ($this->pago_con_nomina == 0 && $this->via_serfin == 1) {
            $metodo = 'serfin';
        }

        return $metodo;
    }

    public function metodo_de_pago_show()
    {
        if ($this->pago_con_nomina == 1 && $this->via_serfin == 0) {
            $metodo = 'Descuento por nomina';
        } elseif ($this->pago_con_nomina == 0 && $this->via_serfin == 0) {
            $metodo = 'Descuento por terminal';
        } elseif ($this->pago_con_nomina == 0 && $this->via_serfin == 1) {
            $metodo = 'Descuento por Serfin';
            // $metodo = 'Tarjeta / Banca electrónica';
        } else {
            $metodo = 'Sin definir';
        }

        return $metodo;
    }

    public function getComoSeEnteroAttribute()
    {
        if (isset($this->cliente)) {

            switch ($this->cliente->como_se_entero) {
                case '3':
                    $label = 'Búsqueda WEb';
                    break;
                case '4':
                    $label = 'Flyer promocional';
                    break;
                case '5':
                    $label = 'Recomendación';
                    break;
                case '6':
                    $label = 'Otros';
                    break;
                case '7':
                    $label = 'Llamada telemarketing';
                    break;
                case '8':
                    $label = 'Venta directa';
                    break;
                case '10':
                    $label = 'Gopacific';
                    break;
                case '11':
                    $label = 'Transporte publico';
                    break;
                case '12':
                    $label = 'IMSS - CLM';
                    break;
                case '13':
                    $label = 'Redes Sociales';
                    break;

                default:
                    $label = 'S/R';
                    break;
            }

        } else {
            $label = 'S/R';
        }
        return $label;
    }



    public function scopeMetodoCobro($q, $request)
    {
        if (isset($request->nomina) && isset($request->terminal) && !isset($request->viaserfin)) {
            $query = $q->orwhere(['pago_con_nomina' => "1", 'via_serfin' => "0"]);
        } elseif (isset($request->nomina) && !isset($request->terminal) && isset($request->viaserfin)) {
            $query = $q->orwhere(['pago_con_nomina' => "1", 'via_serfin' => "1"]);
        } elseif (isset($request->nomina) && !isset($request->terminal) && !isset($request->viaserfin)) {
            $query = $q->where('pago_con_nomina', "1");
        } elseif (!isset($request->nomina) && !isset($request->terminal) && isset($request->viaserfin)) {
            $query = $q->where('via_serfin', "1")->whereNotNull('sys_key');
        } elseif (!isset($request->nomina) && isset($request->terminal) && !isset($request->viaserfin)) {
            $query = $q->where(['pago_con_nomina' => "0", 'via_serfin' => "0"]);
        } elseif (!isset($request->nomina) && isset($request->terminal) && isset($request->viaserfin)) {
            $query = $q->where('pago_con_nomina', "0");
        } elseif (!isset($request->nomina) && !isset($request->terminal) && !isset($request->viaserfin)) {
            $query = $q->orwhere(['pago_con_nomina' => "1", 'via_serfin' => "1"]);
        }

        return $query;
    }

    public function imagenes()
    {
        return $this->hasMany(Imagen::class, 'model_id', 'id');
    }

    public function srt()
    {
        return $this->hasMany(Serfinrespuestas::class, 'contrato_id', 'id');
    }


    public function validarComisiones()
    {
        $num_segmentos = $this->pagos()->where('cantidad','!=',0)->where('segmento','!=',0)->count();

        if ($num_segmentos != 0) {
            $primerPago             = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->orderBy('segmento','ASC')->first();
            $primerSegmento         = $primerPago->segmento;
            // dd($num_segmentos, $primerPago, $primerSegmento, $primerPago->historial_desc);
            /**
             * Validamos los pagos quincenales
             */
            if ($num_segmentos >= 23 && $num_segmentos <= 25 || $num_segmentos >= 35 && $num_segmentos <= 37) {
                if ($primerPago->estatus === 'Pagado') {

                    $motivo_rechazo =  $this->srt()->where('pago_id', $primerPago->id)->first();
                    $data['srt']        = ($motivo_rechazo != null) ? $motivo_rechazo->motivo_del_rechazo : 'OK';
                    $data['pagable']    = true;
                    $data['estatus_com']    = ($primerPago->estatus === 'Pagado') ? 'Pagable' : 'Pendiente';
                }else{
                    $pagosPagados       = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Pagado')->count();
                    $pagosRechazados    = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Rechazado')->count();

                    if ($pagosPagados != null || $pagosRechazados!= null) {
                        $ultimoPago = $this->pagos()->with('historial')->whereNotIn('estatus', ['Por Pagar'])->whereNotIn('segmento',[0])->orderBy('id', 'DESC')->first();

                        $srt = $this->srt()->orderBy('id', 'DESC')->first();

                        $data['srt']            = ($srt != null) ? $srt->motivo_del_rechazo : (($pagosPagados > $pagosRechazados) ? 'OK' : 'Pendiente');
                        $data['pagable']        = $pagosPagados > $pagosRechazados;
                        $data['estatus_cum']    = ($pagosPagados > $pagosRechazados) ? 'Pagable' : 'Pendiente';
                        
                    }else{
                        $data['estatus_cum']    = 'Pendiente';
                        $data['pagable']        = false; 
                        $data['srt']            = 'Pendiente';
                    }
                }    


            /**
             * validamos los pagos semanales
             */
            }elseif($num_segmentos >= 47 && $num_segmentos <= 49 || $num_segmentos >= 71 && $num_segmentos <= 73){

            /**
             * Validamos los pagos mensuales
             */
            }else{

            }
            return $data;
        }
    }

    public function validarComisionQuincenal($primerPago)
    {
        if ($primerPago != null && $primerPago->estatus === 'Pagado') {
            $motivo_rechazo =  $this->srt()->where('pago_id', $primerPago->id)->first();

            $data['srt']        = ($motivo_rechazo != null) ? $motivo_rechazo->motivo_del_rechazo : 'OK';
            $data['pagable']    = true;
            $data['estatus_com']    =  ($primerPago->estatus === 'Pagado') ? 'Pagable' : 'Pendiente';
        }else{
            $pagosPagados       = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Pagado')->count();
            $pagosRechazados    = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Rechazado')->count();

            if ($pagosPagados != null || $pagosRechazados!= null) {
                $ultimoPago = $this->pagos()->with('historial')->whereNotIn('estatus', ['Por Pagar'])->whereNotIn('segmento',[0])->orderBy('id', 'DESC')->first();

                // dd($ultimoPago->historial_desc[0]);
                $srt = $this->srt()->orderBy('id', 'DESC')->first();

                $data['srt']            = ($srt != null) ? $srt->motivo_del_rechazo : (($pagosPagados > $pagosRechazados) ? 'OK' : 'Pendiente');
                $data['pagable']        = $pagosPagados > $pagosRechazados;
                $data['estatus_com']    = ($pagosPagados > $pagosRechazados) ? 'Pagable' : 'Rechazado';
                
            }else{
                $data['srt']            = 'Pendiente';
                $data['pagable']        = false; 
                $data['estatus_com']    = 'Pendiente';
            }
        }    

        $this->actualizarComisiones($data);
        $this->actualizarContrato($data);

        return $data;
    }

    public function validarComisionSemanal($primerPago)
    {
        $pagosConsecutivosPagados = 0;

        $pagos = $this->pagos()->where('cantidad', '!=', 0.0)->where('segmento','!=', 0)->orderBy('segmento','ASC')->get();
        $numSegmentos = count($pagos);
        // dd($pagos);
        $bandera = true;


        $pagosPagados       = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Pagado')->count();
        $pagosRechazados    = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Rechazado')->count();
     
        for ($i = 0; $i < $numSegmentos - 1; $i++) {
            if ($pagos[$i]->estatus === 'Pagado' && $pagos[$i + 1]->estatus === 'Pagado') {
                $srt = $this->srt()->where('pago_id', $pagos[$i + 1]->id)->orderBy('id','DESC')->first();
                $data['srt']            = ($srt != null) ? $srt->motivo_del_rechazo : 'N/A';
                $data['pagable']        = true;
                $data['estatus_com']    = 'Pagable';
                $bandera = false;
                break;  
            }
            break;
        }

        // dd($bandera, $pagosPagados, $pagosRechazados);
        if ($bandera && ($pagosPagados != null || $pagosRechazados!= null)) {
            foreach ($pagos as $pago) {
                if ($pago->estatus === 'Pagado') {
                    $pagosConsecutivosPagados++;

                    // Establecer el número consecutivo necesario (ajusta según tus necesidades)
                    $numeroConsecutivoNecesario = 4;

                    if ($pagosConsecutivosPagados === $numeroConsecutivoNecesario) {
                        // $srt = $this->srt()->where('pago_id', $pago->id)->orderBy('id','DESC')->first();
                        $srt = Serfinrespuestas::where('pago_id', $pago->id)->orderBy('id','DESC')->first();
                        // dd($srt);
                        $data['srt']            = ($srt != null) ? $srt->motivo_del_rechazo : 'N/A';
                        $data['pagable']        = true;
                        $data['estatus_com']    = 'Pagable';
                        break;
                    }
                } else {
                    // Reiniciar el contador si el pago actual no está pagado
                    $pagosConsecutivosPagados = 0;
                    // $data['srt']            = 'N/A';
                    $srt = $this->srt()->where('pago_id', $pago->id)->orderBy('id','DESC')->first();
                    $data['srt']            = ($srt != null) ? $srt->motivo_del_rechazo : 'N/A';
                    $data['pagable']        = false;
                    $data['estatus_com']    = 'Pendiente';
                }
            }
        }else{
            $data['srt']            = 'N/A';
            $data['pagable']        = false;
            $data['estatus_com']    = 'Pendiente';
        }


        $this->actualizarComisiones($data);
        $this->actualizarContrato($data);
        return $data;
    }

    public function validarComisionMensual($primerPago)
    {
        if ($primerPago->estatus === 'Pagado') {
            $motivo_rechazo =  $this->srt()->where('pago_id', $primerPago->id)->first();

            $data['srt']        = ($motivo_rechazo != null) ? $motivo_rechazo->motivo_del_rechazo : 'OK';
            $data['pagable']    = true;
            $data['estatus_com']    =  ($primerPago->estatus === 'Pagado') ? 'Pagable' : 'Pendiente';
        }else{
            $pagosPagados       = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Pagado')->count();
            $pagosRechazados    = $this->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Rechazado')->count();

            if ($pagosPagados != null || $pagosRechazados!= null) {
                $ultimoPago = $this->pagos()->with('historial')->whereNotIn('estatus', ['Por Pagar'])->whereNotIn('segmento',[0])->orderBy('id', 'DESC')->first();

                // dd($ultimoPago->historial_desc[0]);
                $srt = $this->srt()->orderBy('id', 'DESC')->first();

                $data['srt']            = ($srt != null) ? $srt->motivo_del_rechazo : (($pagosPagados > $pagosRechazados) ? 'OK' : 'Pendiente');
                $data['pagable']        = $pagosPagados > $pagosRechazados;
                $data['estatus_com']    = ($pagosPagados > $pagosRechazados) ? 'Pagable' : 'Rechazado';
                
            }else{
                $data['srt']            = 'Pendiente';
                $data['pagable']        = false; 
                $data['estatus_com']    = 'Pendiente';
            }
        }    

        $this->actualizarComisiones($data);
        $this->actualizarContrato($data);

        return $data;
    }


    public function actualizarComisiones($data)
    {
        if ($data['estatus_com'] === 'Pagado' || $data['estatus_com'] === 'Pagable') {
            Comision::where('contrato_id', $this->id)
                ->update([
                    'pagable' => 1,
                    'motivo_rechazo' => $data['srt'],
                    'estatus' => $data['estatus_com'],
                    'modified' => Carbon::now()
                ]);
        }else{
            Comision::where('contrato_id', $this->id)
                ->update([
                    'motivo_rechazo' => $data['srt'],
                    'estatus' => $data['estatus_com'],
                    'modified' => Carbon::now()
                ]);
        }
    }

    public function actualizarContrato($data)
    {
        if ($data['estatus_com'] === 'Pagado' || $data['estatus_com'] === 'Pagable') {
            Contrato::where('id', $this->id)
                ->update([
                    'estatus_comisiones' => 'procesado',
                    'comisiones_actualizadas' => 1,
                    'modified' => Carbon::now()
                ]);
        }else{
            Contrato::where('id', $this->id)
                ->update([
                    'estatus_comisiones' => 'procesado',
                    'comisiones_actualizadas' => 0,
                    'modified' => Carbon::now()
                ]);
        }
    }

    public function sp_clientes_getContratos($id_usuario) 
    {
        $response['data']=DB::select('CALL sp_clientes_getContratos(?,@success, @message, @log)', [$id_usuario]);
        $response['success']=DB::select('SELECT @success AS success')[0]->success;
        $response['message']=DB::select('SELECT @message AS message')[0]->message;
        $response['log']=DB::select('SELECT @log AS log')[0]->log;
        $response=json_decode(json_encode($response), true);
        //Log::debug("response  sp_clientes_getContratos :: ".print_r($response,1));
        return $response;
    }

    public function sp_contratos_porUsuario($id_usuario) 
    {
        $response['data']=DB::select('CALL sp_contratos_porUsuario(?,@success, @message, @log)', [$id_usuario]);
        $response['success']=DB::select('SELECT @success AS success')[0]->success;
        $response['message']=DB::select('SELECT @message AS message')[0]->message;
        $response['log']=DB::select('SELECT @log AS log')[0]->log;
        $response=json_decode(json_encode($response), true);
        //Log::debug("response  sp_contratos_porUsuario :: ".print_r($response,1));
        return $response;
    }

}
