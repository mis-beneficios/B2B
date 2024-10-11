<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table    = 'bancos';
    public $timestamps  = false;
    protected $fillable = [
        'title',
        'clave',
        'ignorar_en_via_serfin',
        'paise_id',
        'created',
        'modified',
    ];
    public function tarjetas()
    {
        return $this->hasMany(Tarjeta::class);
    }

    public function pais()
    {
        return $this->belongsTo(Pais::class, 'paise_id');
    }
}
