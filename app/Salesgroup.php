<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesgroup extends Model
{
    protected $table   = 'salesgroups';
    public $timestamps = false;

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'ventas',
        'supervisor'
    ];

    public function ejecutivo()
    {
        return $this->hasMany(User::class);
    }
}
