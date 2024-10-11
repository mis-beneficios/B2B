<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $table = 'temporadas';

    public $timestamps = false;

    protected $fillable = [
        'regione_id',
        'title',
        'fecha_de_inicio',
        'fecha_de_termino',
        'created',
        'modified',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'regione_id');
    }
}
