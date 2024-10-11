<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AlertasExport implements FromView, ShouldAutoSize
{
    public function __construct($alertas)
    {
        $this->alertas = $alertas;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.mx.filtrado_alertas', [
            'alertas' => $this->alertas,
        ]);
    }
}
