<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SorteoConvenioExport implements FromView, ShouldAutoSize
{

    public function __construct($registros)
    {
        $this->registros = $registros;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.mx.sorteo_convenio', [
            'registros' => $this->registros,
        ]);
    }
}
