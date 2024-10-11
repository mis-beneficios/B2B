<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table    = 'habitaciones';
    public $timestamps  = false;
    protected $fillable = [
        "user_id",
        "padre_id",
        "estancia",
        "reservacione_id",
        "noches",
        "adultos",
        "menores",
        "juniors",
        "adultos_extra",
        "menores_extra",
        "juniors_extra",
        "created",
        "modified",
        "fecha_de_ingreso",
        "fecha_de_salida",
        "edad_menor_1",
        "edad_menor_2",
        "edad_menor_3",
        "edad_menor_4",
        "edad_menor_5",
        "edad_junior_1",
        "edad_junior_2",
        "edad_junior_3",
        "edad_junior_4",
        "edad_junior_5",
    ];

    public function reservaciones()
    {
        return $this->belongsTo(Reservacion::class, 'reservacione_id', 'id');
    }
}
