<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodigoPostal extends Model
{
    protected $connection = 'hometravel';

    protected $table = 'codigos_postales';
}
