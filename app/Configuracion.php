<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table   = 'config';
    // public $timestamps = false;

    protected $fillable = [
        'name',
        'data',
        'notes',
    ];
}
