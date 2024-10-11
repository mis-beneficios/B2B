<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table    = 'actividades';
    protected $fillable = [
        'user_id',
        'concal_id',
        'title',
        'notas',
    ];

    public function concal()
    {
        return $this->belongsTo(Concal::class, 'concal_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
