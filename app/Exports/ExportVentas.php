<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportVentas implements FromView, ShouldAutoSize
{
    public function __construct($ventas)
    {
        $this->ventas = $ventas;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.mx.filtrado_ventas', [
            'ventas' => $this->ventas,
        ]);
    }
}
