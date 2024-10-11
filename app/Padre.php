<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    protected $table   = 'padres';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'user_id',
        'title',
        'correo_institucional',
        'nombre',
    ];

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    // public function usuario_admin()
    // {
    //     // return $this->hasOne(User::class, 'user_id');
    //     return $this->belongsTo(User::class, 'id', 'user_id');
    // }

    public function vendedor()
    {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class);
    }

}
