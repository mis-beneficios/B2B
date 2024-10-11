<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table   = 'hotels';
    public $timestamps = false;

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }
}
