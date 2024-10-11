<?php

namespace App\Imports;

use App\Comision;
use Maatwebsite\Excel\Concerns\ToModel;

class ComisionesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Comision([
            'folio'   => $row[0],
            'estatus' => $row[1],
            'archivo' => $row[2],
            'tipo'    => $row[3],
        ]);
    }
}
