<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ClientesEjecutivoExport implements FromView,ShouldAutoSize
{
   public function __construct($datos)
    {
        $this->contratos = $datos;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {

        $contratos = $this->contratos;
        return view('exports.mx.clientes_ejecutivo_export', compact('contratos'));
    }
}
