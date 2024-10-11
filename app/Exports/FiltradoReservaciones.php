<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FiltradoReservaciones implements FromView, ShouldAutoSize, WithColumnFormatting
{

    public function __construct($reservaciones)
    {
        $this->reservaciones = $reservaciones;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        // dd($this->reservaciones);
        $reservaciones = $this->reservaciones;
        return view('exports.mx.filtrado_reservaciones', compact('reservaciones'));
    }

    public function columnFormats(): array
    {
        return [
            // 'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Q'  => NumberFormat::FORMAT_TEXT,
            'S'  => NumberFormat::FORMAT_TEXT,
            'U'  => NumberFormat::FORMAT_TEXT,
            'V'  => NumberFormat::FORMAT_TEXT,
            'X'  => NumberFormat::FORMAT_TEXT,
            'Z'  => NumberFormat::FORMAT_TEXT,
            'AB' => NumberFormat::FORMAT_TEXT,
            'AC' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
