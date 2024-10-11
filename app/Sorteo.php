<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sorteo extends Model
{
    protected $table   = 'sorteos';
    public $timestamps = false;

    protected $fillable = [
        'convenio',
        'llave',
        'fecha_inicio',
        'fecha_fin',
        'pais',
        'flag',
        'cuerpo_correo',
        'from_correo',
        'from_final',
        'img_final',
        'convenio_id',
        'num_empleado',
        'tipo_sorteo',
        'created_at',
    ];

    public function estatus()
    {
        if ($this->flag == 1) {
            $data['color']   = 'danger';
            $data['estatus'] = 'Finalizado';
        } else {
            $data['color']   = 'info';
            $data['estatus'] = 'Pendiente';
        }

        return $data;
    }
}
