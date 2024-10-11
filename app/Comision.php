<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comision extends Model
{
    protected $table   = 'comisiones';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'contrato_id',
        'cantidad',
        'pagable',
        'pagado',
        'concepto',
        'convenio_id',
        'cliente_nombre',
        'cliente_username',
        'motivo_rechazo',
        'estatus',
        'pago_id',
        'tipo',
        'pagado_en',
        'created',
        'modified',
        'campana_inicio',
        'campana_fin',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'contrato_id');
    }


    public function pago()
    {
        return $this->belongsTo(Pago::class, 'pago_id');
    }

    public function pagableQuincenal()
    {
        $data['srt']            = '';
        $data['estatus']        = '';
        $data['pago_id_param']  = '';
        $data['segmento_pago']  = '';

        $primerPago             = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->orderBy('segmento','ASC')->first();
        $data['primer_segmento']  = $primerPago->segmento;

        $pagosPagados       = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Pagado')->count();
        $pagosRechazados    = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Rechazado')->count();

        if ($pagosPagados > $pagosRechazados) {
            if ($primerPago->estatus === 'Pagado') {
                $data['pagable'] =  $primerPago->estatus === 'Pagado';
                $data['estatus'] =  $primerPago->estatus; 
                $data['pago_id'] =  $primerPago->id; 
                if ($primerPago->historial_desc != null) {
                    foreach ($primerPago->historial_desc as $key) {
                        $data['srt']     =  $key->motivo_del_rechazo;
                        break;
                    }
                }else{
                    $data['srt'] = $primerPago->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                }
            } else {
                $pagosPagados       = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Pagado')->count();
                $pagosRechazados    = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Rechazado')->count();
                if ($pagosPagados != null || $pagosRechazados!= null) {
                    $ultimoPago         = $this->contrato->pagos()->with('historial')->whereNotIn('estatus', ['Por Pagar'])->whereNotIn('segmento',[0])->orderBy('id', 'DESC')->first();
                    
                    $data['estatus']    = $ultimoPago->estatus;
                    $data['pagable']    = $pagosPagados > $pagosRechazados;
                    $data['pago_id']    = $ultimoPago->id; 
                    
                    if ($ultimoPago->historial_desc != null) {
                        foreach ($ultimoPago->historial_desc as $key) {
                            $data['srt']     =  $key->motivo_del_rechazo;
                            break;
                        }
                    }else{
                        $data['srt'] = $ultimoPago->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                    }
                }else{

                    $data['estatus']    = 'Pendiente';
                    $data['pagable']    = false;
                    $data['pago_id']    = ''; 
                    $data['srt']        = 'Pendiente';
                }
                
            } 
        }

        return $data;

    }

    // Método para determinar si la comisión es pagable
    public function esPagable($pago_id = null)
    {

        /**
         * Definicion de variables a comparar
         */
        $data['srt']            = '';
        $data['estatus']        = '';
        $data['pago_id_param']  = '';
        $data['segmento_pago']  = '';


        $data['pago_id_param']  = $pago_id;
        $primerPago             = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->orderBy('segmento','ASC')->first();
        // dd($primerPago);
        $data['segmento_pago']  = $primerPago->segmento;
        
        $num_segmentos          = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->count();
        $data['num_segmentos']  = $num_segmentos;

        /**
         * Validamos el numero de segmentos generados para poder validar los pagos que deben ser pagados para procesar la comision
         */
        if ($num_segmentos == 36 || $num_segmentos == 24 || $num_segmentos == 12) {
            if ($primerPago->estatus === 'Pagado') {
                $data['pagable'] =  $primerPago->estatus === 'Pagado';
                $data['estatus'] =  $primerPago->estatus; 
                $data['pago_id'] =  $primerPago->id; 
                if ($primerPago->historial_desc != null) {
                    foreach ($primerPago->historial_desc as $key) {
                        $data['srt']     =  $key->motivo_del_rechazo;
                        break;
                    }
                }else{
                    $data['srt'] = $primerPago->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                }
            } else {
                $pagosPagados       = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Pagado')->count();
                $pagosRechazados    = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Rechazado')->count();
                if ($pagosPagados != null || $pagosRechazados!= null) {
                    $ultimoPago         = $this->contrato->pagos()->with('historial')->whereNotIn('estatus', ['Por Pagar'])->whereNotIn('segmento',[0])->orderBy('id', 'DESC')->first();
                    
                    $data['estatus']    = $ultimoPago->estatus;
                    $data['pagable']    = $pagosPagados > $pagosRechazados;
                    $data['pago_id']    = $ultimoPago->id; 
                    
                    if ($ultimoPago->historial_desc != null) {
                        foreach ($ultimoPago->historial_desc as $key) {
                            $data['srt']     =  $key->motivo_del_rechazo;
                            break;
                        }
                    }else{
                        $data['srt'] = $ultimoPago->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                    }
                }else{

                    $data['estatus']    = 'Pendiente';
                    $data['pagable']    = false;
                    $data['pago_id']    = ''; 
                    $data['srt']        = 'Pendiente';
                }
                
            } 
        }elseif(($num_segmentos >= 47 && $num_segmentos <= 48) || ($num_segmentos >= 70 && $num_segmentos <= 72)){ 
        //Validamos si los pagos son catorcenales o semanales para validar los pagos pagados para procesar comisiones
            $act_pago = Pago::where('id',$pago_id)->first(); 
            
            $ant_pago = $this->contrato->pagos()->where('segmento', $act_pago->segmento - 1)->where('segmento','!=', 0)->where('cantidad', '!=', 0)->first();
            $sig_pago = $this->contrato->pagos()->where('segmento', $act_pago->segmento + 1)->where('segmento','!=', 0)->where('cantidad', '!=', 0)->first();


            $pagos = $this->contrato->pagos()
                ->where('segmento','!=', 0)
                ->where('cantidad', '!=', 0)
                ->orderBy('segmento')
                ->get();
            
            // dd($act_pago, $ant_pago, $sig_pago);
            $pagosAprobados     = $this->contrato->pagos()->where('estatus', 'Pagado')->count();
            $pagosRechazados    = $this->contrato->pagos()->where('estatus', 'Rechazado')->count();

            // dd($primerPago, $act_pago, $ant_pago, $sig_pago, $pagos, $pagosAprobados, $pagosRechazados);
            // echo "Aprobados ". $pagosAprobados;
            // echo "<br>";
            // echo "Rechazado ". $pagosRechazados;
            // echo "<br>";
            // echo "pago actual". $act_pago;
            // echo "<br>";
            // echo "<br>";
     

            for ($i = 0; $i < $pagos->count() - 1; $i++) {
                // echo $pagos[$i + 1];
                // echo "<br>";
                if ($pagos[$i]->estatus === 'Pagado' && $pagos[$i + 1]->estatus === 'Pagado') {
                    $data['estatus']    = $pagos[$i + 1]->estatus;
                    $data['pagable']    = true;
                    $data['pago_id']    = $pagos[$i + 1]->id; 
                    if ($pagos[$i + 1]->historial_desc != null) {
                        foreach ($pagos[$i + 1]->historial_desc as $key) {
                            $data['srt']     =  $key->motivo_del_rechazo;
                            break;
                        }
                    }else{
                        $data['srt'] = $pagos[$i + 1]->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                    }
                }else{
                    if ($act_pago->estatus === 'Pagado') {
                        if (( isset($ant_pago) && $ant_pago->estatus === 'Pagado') || (isset($sig_pago) && $sig_pago->estatus === 'Pagado')) {
                            $data['estatus']    = (isset($ant_pago) && $ant_pago->estatus === 'Pagado') ? $ant_pago->estatus : $sig_pago->estatus;
                            $data['pagable']    = true;
                            $data['pago_id']    = ( $ant_pago != null && $ant_pago->estatus === 'Pagado') ? $ant_pago->id : $sig_pago->id;
                            if (($ant_pago != null && $ant_pago->estatus === 'Pagado') ? $ant_pago->historial_desc : $sig_pago->historial_desc != null) {
                                foreach ($pagos[1]->historial_desc as $key) {
                                    $data['srt']     =  $key->motivo_del_rechazo;
                                    break;
                                }
                            }else{
                                $data['srt'] = $pagos[1]->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                            }
                        }else{
                            $data['estatus']    = ($ant_pago != null && $ant_pago->estatus === 'Pagado') ? $ant_pago->estatus : $sig_pago->estatus;
                            $data['pagable']    = false;
                            $data['pago_id']    =  ($ant_pago != null && $ant_pago->estatus === 'Pagado')? $ant_pago->id : $sig_pago->id;
                            if (($ant_pago != null && $ant_pago->estatus === 'Pagado') ? $ant_pago->historial_desc : $sig_pago->historial_desc != null) {
                                foreach ($pagos[1]->historial_desc as $key) {
                                    $data['srt']     =  $key->motivo_del_rechazo;
                                    break;
                                }
                            }else{
                                $data['srt'] = $pagos[1]->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                            }    
                        }
                    }else{
                        if ($pagosRechazados >= 4) {
                            $seg_pagados = 0;
                            $ult_pago = $this->contrato->pagos()->whereIn('estatus', ['Rechazado'])->orderBy('segmento', 'DESC')->first();
                            
                            for ($j=0; $j <= $pagosRechazados; $j++) { 
                                // echo $pagos[$ult_pago->segmento + $j];
                                // echo "<br>";
                                if ($pagos[$ult_pago->segmento + $j]->estatus === 'Pagado') {
                                    $seg_pagados++;
                                }
                            }

                            if ($seg_pagados == $pagosRechazados + 1) {
                                $data['estatus']    = 'Pagado';
                                $data['pagable']    = true;
                                $data['pago_id']    = '';
                                $data['srt']        = 'OK';
                                
                                break;
                            }else{
                                $data['estatus']    = 'Pendiente';
                                $data['pagable']    = false;
                                $data['pago_id']    = '';
                                $data['srt']        = 'Pendiente';
                                
                                break;
                            }
                        }
                    }
                }
            }

            /////////////////////////
            //Funcional            //
            /////////////////////////
            // if ($primerPago->estatus == 'Pagado') {
            //     $ant = $data['segmento_pago'] - 1;
            //     $seg = $data['segmento_pago'] + 1;

            //     $ant_pago = $this->contrato->pagos()->where('segmento', $ant)->where('segmento','!=', 0)->where('cantidad', '!=', 0)->first();
            //     $sig_pago = $this->contrato->pagos()->where('segmento', $seg)->where('segmento','!=', 0)->where('cantidad', '!=', 0)->first();
                
            //     if ($ant_pago != null && $ant_pago->estatus == 'Pagado' || $sig_pago != null && $sig_pago->estatus == 'Pagado') {
            //         $data['estatus']        =  ($sig_pago != null) ? $sig_pago->estatus :$primerPago->estatus; 
            //         $data['pago_id']        =  ($sig_pago != null) ? $sig_pago->id :$primerPago->id; 
            //         $data['pagable']        =  $primerPago->estatus === 'Pagado';
            //     }else{
            //         $data['estatus']        =  'Pendiente'; 
            //         $data['pago_id']        =  $primerPago->id; 
            //         $data['pagable']        =  false;                    
            //     }

            //     if ($primerPago->historial_desc != null) {
            //         foreach ($primerPago->historial_desc as $key) {
            //             $data['srt']     =  $key->motivo_del_rechazo;
            //             // $data['srt']     =  'Entro al pagado';
            //             break;
            //         }
            //     }else{
            //         $data['srt'] = $primerPago->estatus === 'Pagado' ? 'OK' : 'Pendiente';
            //     }


            // }else {
            //     // $pagosPagados       = $this->contrato->pagos()->where('estatus', 'Pagado')->count();
            //     // $pagosRechazados    = $this->contrato->pagos()->where('estatus', 'Rechazado')->count();
            //     // $ultimoPago         = $this->contrato->pagos()->with('historial')->whereNotIn('estatus', ['Por Pagar'])->whereNotIn('segmento',[0])->orderBy('id', 'DESC')->first();
            //     // $data['estatus']    = $ultimoPago->estatus;
            //     // $data['pagable']    = $pagosPagados > $pagosRechazados;
            //     // $data['pago_id']    = $ultimoPago->id;
                
            //     $consecutivos = 2;
            //     $rechazados = 4;
            //     $pagos = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad', '!=', 0)->whereNotIn('estatus', ['Por Pagar','Bonificado'])->orderBy('segmento')->get();
            //     $pagosAprobados     = $this->contrato->pagos()->where('estatus', 'Pagado')->count();
            //     $pagosRechazados    = $this->contrato->pagos()->where('estatus', 'Rechazado')->count();


            //     dd($pagos->toArray(), $pagosAprobados, $pagosRechazados);
            //     // if ($pagosRechazados == $rechazados) {
            //     //     //4 pagos han sido rechazados
                    
            //     // }



            //     // for ($i=0; $i <= $pagos->count()  ; $i++) { 
                    
            //     // }
 
            // }

            // if ($primerPago->historial_desc != null) {
            //     foreach ($primerPago->historial_desc as $key) {
            //         $data['srt']     =  $key->motivo_del_rechazo;
            //         break;
            //     }
            // }else{
            //     $data['srt'] = $primerPago->estatus === 'Pagado' ? 'OK' : 'Pendiente';
            // }

        }else{
            if ($primerPago->estatus == 'Pagado') {
                $data['pagable'] =  $primerPago->estatus === 'Pagado';
                $data['estatus'] =  $primerPago->estatus; 
                $data['pago_id'] =  $primerPago->id; 
                if ($primerPago->historial_desc != null) {
                    foreach ($primerPago->historial_desc as $key) {
                        $data['srt']     =  $key->motivo_del_rechazo;
                        break;
                    }
                }else{
                    $data['srt'] = $primerPago->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                }
            } else {
                $pagosPagados       = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Pagado')->count();
                $pagosRechazados    = $this->contrato->pagos()->where('segmento','!=', 0)->where('cantidad','!=', 0)->where('estatus', 'Rechazado')->count();
                $ultimoPago         = $this->contrato->pagos()->with('historial')->whereNotIn('estatus', ['Por Pagar'])->whereNotIn('segmento',[0])->orderBy('id', 'DESC')->first();
                $data['estatus']    = $ultimoPago->estatus;
                $data['pagable']    = $pagosPagados > $pagosRechazados;
                $data['pago_id']    = $ultimoPago->id; 
                if ($ultimoPago->historial_desc != null) {
                    foreach ($ultimoPago->historial_desc as $key) {
                        $data['srt']     =  $key->motivo_del_rechazo;
                        break;
                    }
                }else{
                    $data['srt'] = $ultimoPago->estatus === 'Pagado' ? 'OK' : 'Pendiente';
                }
            }
        }
        // dd($data);
        return $data;
    }
}
