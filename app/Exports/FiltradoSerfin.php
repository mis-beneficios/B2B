<?php

namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FiltradoSerfin implements  FromView, ShouldAutoSize, WithColumnFormatting, WithProperties
{
    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('exports.mx.serfin.filtrado_serfin', [
            'data' => $this->data,
        ]);
    }

    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-23
     * Cambiamos el formato de la columna a texto plano para no tener problema al momento de enviar el archivo a serfin
     */
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT,
            // 'F' => NumberFormat::FORMAT_TEXT,
            'F' => NumberFormat::FORMAT_NUMBER_00,
            'H' => NumberFormat::FORMAT_TEXT,
            'I' => NumberFormat::FORMAT_TEXT,
            'J' => NumberFormat::FORMAT_TEXT,
            'k' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
            'M' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-06-23
     * Se agregan las propiedades al archivo excel
     */
    public function properties(): array
    {
        return [
            'creator'        => 'ISW Diego Sanchez',
            'lastModifiedBy' => 'ISW Diego Sanchez',
            'title'          => 'Suspendidos',
            'description'    => 'Filtrado de folios suspendidos',
            'manager'        => 'ISW Diego Sanchez',
            'company'        => 'Mis Beneficios Vacacionales',
        ];
    }
}
