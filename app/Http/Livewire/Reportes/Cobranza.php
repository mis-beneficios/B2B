<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Contrato;
use App\Reservacion;
use Illuminate\Http\Request;
use DB;

class Cobranza extends Component
{
    public $fecha_inicio, $fecha_fin, $estatus; 
    public $activos, $viajados, $suspendidos, $res_activa;
    public $ver_activos = false;
    public $ver_suspendidos = false;
    public $ver_viajados = false;


    public function mount()
    {  
        // $this->estatus_contratos = Contrato::groupBy('estatus')->get(['estatus']);
    }

    public function get_filter()
    {
        // dd($this->fecha_inicio, $this->fecha_fin, $this->estatus);
        $this->obtener_activos();
        $this->obtener_viajados();
        // dd($this->viajados);
    }



     /**
     * Autor: Isw. Diego Sanchez
     * Creado: 2022-06-13
     * Consilta para obtener el filtrado de las ventas solicitadas por el usuario
     * se usa en mas de un metodo, revisar la modificacion en metodo @exportFiltrado y @downloadFiltrado
     * @param  Request $request
     * @return array data
     */
    public function getDataFiltrado()
    {
        $this->ver_activos = true;
        $this->activos       = Contrato::whereBetween(DB::raw('date(created)'), [$this->fecha_inicio, $this->fecha_fin])
            ->with(['cliente', 'tarjeta', 'padre', 'tarjeta.r_banco', 'padre.vendedor', 'pagos'])
            ->whereHas('convenio', function ($q) {
                $q->where('paise_id', env('APP_PAIS_ID'));
            })
            ->withCount(['pagos as cuotas_pagos'])
            ->withCount(['pagos as pagos_realizados' => function ($query) {
                $query->where('estatus', 'Pagado');
            }])
            ->withMax('pagos','fecha_de_pago')
            ->where('estatus', 'Comprado', 'por_autorizar')
            ->having('pagos_realizados', '>=', 1)
            ->groupBy('id')
            ->orderBy('user_id')
            // ->limit(5)
            ->get();
        // dd(count($ventas_total));
    }



    public function obtener_activos()
    {
        $this->ver_activos = true;
        $this->activos       = Contrato::whereBetween(DB::raw('date(created)'), [$this->fecha_inicio, $this->fecha_fin])
            ->with(['cliente', 'tarjeta', 'padre', 'tarjeta.r_banco', 'padre.vendedor', 'pagos'])
            ->whereHas('convenio', function ($q) {
                $q->where('paise_id', env('APP_PAIS_ID'));
            })
            ->withCount(['pagos as cuotas_pagos'])
            ->withCount(['pagos as pagos_realizados' => function ($query) {
                $query->where('estatus', 'Pagado');
            }])
            ->withMax('pagos','fecha_de_pago')
            ->where('estatus', 'Comprado', 'por_autorizar')
            ->having('pagos_realizados', '>=', 1)
            ->groupBy('id')
            ->orderBy('user_id')
            // ->limit(5)
            ->get();
    }


    public function obtener_viajados()
    {
        $this->ver_viajados = true;
        $this->viajados = Reservacion::whereBetween('fecha_de_ingreso', [$this->fecha_inicio, $this->fecha_fin])
            ->whereDate('fecha_de_salida', '<=', $this->fecha_fin)
            ->whereIn('estatus', ['Viajado','viajado'])
            ->get();
    }

    public function render()
    {
        // dd($this->fecha_inicio, $this->fecha_fin, $this->estatus);
        $estatus_contratos = Contrato::groupBy('estatus')->get(['estatus']);
        // compact('estatus_contratos')
        return view('livewire.reportes.cobranza', ['estatus_contratos' => $estatus_contratos]);

    }
}
