<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActualizarSerfin extends Model
{
    use HasFactory;

    protected $table    = 'actualizacion_serfin';
    protected $fillable = [
        'hmt',
        'hmi',
        'hmt_update',
        'hmi_update',
        'origen_pacific',
        'origen_home',
        'srt_pacific',
        'srt_pacific_update',
        'origen_i',
        'res1',
        'res2',
        'errores_pacific',
        'errores_home',
        'creado'
    ];
}
