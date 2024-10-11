<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Estancia extends Model
{
    protected $table   = 'estancias';
    public $timestamps = false;

    protected $fillable = [
        'solosistema',
        'convenio_id',
        'invitacion_id',
        'title',
        'precio',
        'descuento',
        'habilitada',
        'descripcion',
        'descripcion_formal',
        'noches',
        'adultos',
        'ninos',
        'edad_max_ninos',
        'caducidad',
        'divisa',
        'cuotas',
        'descripcion_formal_es_contrato_completo',
        'estancia_maestra',
        'master_key',
        'calculo_por_venta',
        'precio_por_nino',
        'precio_por_adulto',
        'imagen_de_reemplazo',
        'usd_mxp',
        'slide',
        'estancia_paise_id',
        'comunes_estancia_paise_id',
        'temporada',
        'estancia_especial',
        'hotel_name',
        'enganche_especial',
        'est_especial',
        'destino_id',
        'img_producto',
        'img_descripcion',
        'img_secundaria',
        'img_opcional',
        'slug',
        'tipo',
    ];
    
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->slug = Str::slug($model->title);
        });
    }

    public function contrato()
    {
        return $this->hasMany(Contrato::class);
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class);
    }

    public function destino()
    {
        return $this->belongsTo(Destino::class);
    }

    public function reservaciones()
    {
        return $this->hasMany(Comment::class, 'estancia_id', 'id');
    }

    /**
     * Estancia has many Intento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function intento()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = estancia_id, localKey = id)
        return $this->hasMany(IntentoCompra::class);
    }
}
