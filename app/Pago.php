<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use App\Tarjeta;


class Pago extends Model
{
    protected $table    = 'pagos';
    public $timestamps  = false;
    protected $fillable = [
        'contrato_id',
        'tarjeta_id',
        'segmento',
        'estatus',
        'cantidad',
        'fecha_de_cobro',
        'fecha_de_pago',
        'cobrador',
        'notas',
        'manual',
        'concepto',
        'bloqueo_via_serfin',
        'via_serfin_exported',
        'collector_added',
        'created_by',
        'importado',
        'pagado_desde_santander',
        'modified',
    ];

    // public function contrato()
    // {
    //     return $this->belongsTo(Contrato::class);
    // }

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function tarjeta()
    {
        return $this->belongsTo(Tarjeta::class);
    }

    public function historial()
    {
        return $this->hasMany(Serfinrespuestas::class);
    }

    // public function comision_srt()
    // {
    //     return $this->hasMany(Serfinrespuestas::class)->orderBy('id','DESC')->limit(1);
    // }

    public function historial_desc()
    {
        return $this->hasMany(Serfinrespuestas::class)->orderBy('id', 'DESC')->limit(1);
    }

    public function historial_limit()
    {
        return $this->hasMany(Serfinrespuestas::class)->orderBy('id', 'DESC')->limit(3);
    }

    public function log()
    {
        return $this->hasOne(PagoLog::class, 'pago_id');
    }


    public function comision()
    {
        return $this->hasOne(Comision::class, 'pago_id', 'id');
    }

    public function getLogPagoAttribute()
    {
        if ($this->log != null) {
            return Markdown::convertToHtml($this->log->notas); // <p>foo</p>
        } else {
            return '';
        }
    }

    public function total_pagos($tipo)
    {
        switch ($tipo) {
            case 'pagados':
                $total = $this->where('id', $this->id)->where('estatus', 'Pagado')->sum('cantidad');
                break;
            case 'rechazados':
                $total = $this->where('id', $this->id)->where('estatus', 'Rechazado')->sum('cantidad');
                break;

            case 'por_pagar':
                $total = $this->where('id', $this->id)->where('estatus', 'Por Pagar')->sum('cantidad');
                break;
        }

        return $total;
    }

    public function total_pagos_contrato($contrato_id, $tipo)
    {
        switch ($tipo) {
            case 'pagados':
                $total = $this->where('contrato_id', $contrato_id)->where('estatus', 'Pagado')->sum('cantidad');
                break;
            case 'rechazados':
                $total = $this->where('contrato_id', $contrato_id)->where('estatus', 'Rechazado')->sum('cantidad');
                break;

            case 'por_pagar':
                $total = $this->where('contrato_id', $contrato_id)->where('estatus', 'Por Pagar')->sum('cantidad');
                break;

            default:
                $total = '';
                break;
        }

        return $total;
    }


    public function motivo_rechazo()
    {
        $sfr = '';
        $sfr .= '<ul class="list-unstyled" style="font-size:10px;">';
        if (count($this->historial_limit) >= 1) {
            foreach ($this->historial_limit as $key => $historial) {
                $sfr .= '<li>' . $historial->motivo_del_rechazo . '</li>';
            }
        } else {
            $sfr .= '<li> Sin información</li>';
        }

        $sfr .= '</ul>';

        return $sfr;
    }

    public function color_estatus()
    {
        switch ($this->estatus) {
            case 'Pagado':
                $class = 'success';
                break;
            case 'Rechazado':
                $class = 'danger';
                break;
            case 'Anomalias':
                $class = 'info';
                break;
            default:
                $class = 'inverse';
                break;
        }

// 'Por Pagar'  
// 'Pagado'     
// 'Rechazado'  
// 'Cancelado'  
// 'Bonificado' 
// 'Anomalia'   
// 'pagado_fdt' 
// 'Simulador'  

        return $class;
    }


    /*
     * Scope's
     */

    public function scopePagado($query)
    {
        return $query->where('estatus', 'Pagado')->whereNotIn('cantidad', [0])->where('segmento','!=',0);
    }
    
    public function scopeSegmentosPagados($query)
    {
        return $query->where('estatus','Pagado')->count();
    }

    public function scopeCantidadPendiente($query)
    {
        return $query->whereNotIn('estatus', ['Pagado'])->sum('cantidad');
    }

    public function scopeSegmentosPendientes($query)
    {
        return $query->whereNotIn('estatus', ['Pagado'])->count();
    }

    
    public function scopeEstatusGroup($query)
    {
        return $query->groupBy('estatus');
    }

}
