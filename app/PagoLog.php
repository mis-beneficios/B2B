<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PagoLog extends Model
{
    protected $table   = 'pagoslogs';
    public $timestamps = false;

    protected $fillable = [
        'pago_id',
        'notas',
    ];

    public function pago()
    {
        return $this->belongsTo(Pago::class);
    }
}
