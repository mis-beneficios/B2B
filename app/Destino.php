<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table   = 'destinos';
    public $timestamps = false;

    public function estancias()
    {
        return $this->hasMany(Estancia::class);
    }

    public function hoteles()
    {
        return $this->hasMany(Hotel::class);
    }
}
