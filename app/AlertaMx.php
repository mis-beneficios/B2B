<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertaMx extends Model
{
    protected $table    = 'users_alerts_mx';
    public $timestamps  = false;
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'empresa',
        'referido',
        'created',
        'alerta_user_enviada',
        'alerta_compra',
        'alerta_compra_fecha',
        'alerta_compra_enviada_a',
        'convenio_id',
    ];

}
