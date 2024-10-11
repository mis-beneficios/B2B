<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    use HasFactory;

    protected $table   = 'imagenes';
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
        'model',
        'model_id',
        'nombre',
        'path',
        'driver',
        'user_id',
        'cliente_id'
    ];


    /**
     * Imagen belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // belongsTo(RelatedModel, foreignKey = user_id, keyOnRelatedModel = id)
        return $this->belongsTo(User::class);
    }
}
