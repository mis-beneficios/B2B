<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class BBVAExport implements  FromView, ShouldAutoSize, WithColumnFormatting, WithProperties
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
        return view('exports.mx.serfin.bancomer', [
            'data' => $this->data,
        ]);
    }


    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-08-31
     * Cambiamos el formato de la columna a texto plano para no tener problema al momento de enviar el archivo a serfin 
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_TEXT,
            'G' => NumberFormat::FORMAT_TEXT,
            'k' => NumberFormat::FORMAT_TEXT,
            'L' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-08-31
     * Se agregan las propiedades al archivo excel
     */
    public function properties(): array
    {
        return [
            'creator'        => 'ISW Diego Sanchez',
            'lastModifiedBy' => 'ISW Diego Sanchez',
            'title'          => 'Filtrado BBVA',
            'description'    => 'Filtrado de folios por cobrar por BBVA',
            'manager'        => 'ISW Diego Sanchez',
            'company'        => 'Mis Beneficios Vacacionales',
        ];
    }

}
