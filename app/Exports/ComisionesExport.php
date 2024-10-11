<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ComisionesExport implements FromView, ShouldAutoSize, WithStyles
// , ShouldQueue

{
    // use Exportable, Queueable;
    // ,WithBackgroundColor,WithDefaultStyles
    public function __construct($comisiones)
    {
        $this->comisiones = $comisiones;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.mx.comisiones_export', [
            'comisiones' => $this->comisiones,
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true], 'argb' => '0FF000'],
        ];
    }
}
