<?php

namespace App\Http\Livewire\Comisiones;

use Livewire\Component;
use Auth;
use App\Contrato;
use App\Padre;
use App\Pago;
use App\Comision;
use DB;
use App\Helpers\ComisionesHelper;


class Enganches extends Component
{
    protected  $comis;
    function __construct()
    {
        $this->comis = new ComisionesHelper;
    }
    public $pagos_hoy, $pagos_pagados_hoy, $pagos_pendientes_hoy, $pagos_total, $pagos_pagados_total, $pagos_pendientes;

       
    public function render()
    {
        $comisiones = $this->comis->getComisionesEnganche('2023-11-10', '2023-12-25', Auth::user()->username);
        // dd($comisiones);
        $this->pagos_hoy();
        $this->pagos_pagados_hoy();
        $this->pagos_pendientes_hoy();

        return view('livewire.comisiones.enganches');
    }

    public function pagos_hoy()
    {

        $this->pagos_hoy = Comision::whereHas('pago', function($query){
            $query->whereDate('fecha_de_cobro', date('Y-m-d'));
        })->where(['user_id' => Auth::user()->id, 'tipo' => 'Enganche'])->sum('cantidad');
    }

    public function pagos_pagados_hoy()
    {
        $this->pagos_pagados_hoy = Comision::whereHas('pago', function($query){
            $query->whereDate('fecha_de_cobro', date('Y-m-d'))->where(['concepto' => 'Enganche', 'estatus'=>'Pagado']);
        })->where(['user_id' => Auth::user()->id, 'tipo' => 'Enganche'])->sum('cantidad');
    }

    public function pagos_pendientes_hoy()
    {
        $this->pagos_pendientes_hoy = Comision::whereHas('pago', function($query){
            $query->whereDate('fecha_de_cobro', date('Y-m-d'))->where(['concepto' => 'Enganche', 'estatus'=>'Por Pagar']);
        })->where(['user_id' => Auth::user()->id, 'tipo' => 'Enganche'])->sum('cantidad');
    }

}
