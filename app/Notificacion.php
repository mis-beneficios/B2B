<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'cuerpo',
        'estatus',
        'activo_hasta',
        'show_role',
        'key_cache',
        'user_id',        
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
