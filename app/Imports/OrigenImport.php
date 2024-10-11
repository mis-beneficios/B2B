<?php

namespace App\Imports;

use App\Origen;
use Maatwebsite\Excel\Concerns\ToModel;

class OrigenImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Origen([
            'importe'       => $row[0],
            'fecha'         => $row[1],
            'banco'         => $row[2],
            'tarjeta'       => $row[3],
            'sys_key'       => $row[4],
            'pago_id'       => $row[5],
            'pago_segmento' => $row[6],
            'cliente'       => $row[7],
            'clave'         => $row[8],
            'archivo'       => $row[9],
        ]);

    }
}
