<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table   = 'encuestas';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellidos',
        'telefono',
        'correo',
        'user_id',
        'nivel_satisfaccion',
        'recomendacion',
        'interes',
        'pregunta_1',
        'comentario_1',
        'pregunta_2',
        'comentario_2',
        'pregunta_3',
        'comentario_3',
        'tipo_encuesta',
        'created',
        'modified',
    ];

    /**
     * Tipo de encuesta
     * 1 satisfaccion
     * 2 pacific
     *
     */
}
