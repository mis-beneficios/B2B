<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertaUsa extends Model
{
    protected $table    = 'users_alerts';
    public $timestamps  = false;
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'telefono',
        'empresa',
        'place',
        'compania',
        'people',
        'date_travel',
        'created',
        'alerta_user_enviada',
        'alerta_cliente_enviada',
        'alerta_compra',
        'alerta_compra_fecha',
        'alerta_compra_enviada_a',
        'convenio_id',
    ];

}
