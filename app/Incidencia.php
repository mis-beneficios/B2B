<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Incidencia extends Model
{
    use HasFactory;

    protected $table    = 'incidencias';
    public $timestamps  = false;
    protected $fillable = [
        "user_id",
        "caso",
        "descripcion",
        "estatus",
        "clase",
        "created",
        "created_at",
    ];

    public function diffForhumans()
    {
        return Carbon::create($this->created)->diffForHumans();
    }


    /**
     * User belongs to Incidencias.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // belongsTo(RelatedModel, foreignKey = incidencias_id, keyOnRelatedModel = id)
        return $this->belongsTo(User::class);
    }




}
