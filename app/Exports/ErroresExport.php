<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ErroresExport implements FromView, ShouldAutoSize
{

    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {

        $datos = $this->data;
        return view('exports.mx.serfin.errores', compact('datos'));
    }
}
