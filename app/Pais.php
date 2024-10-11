<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $table   = 'paises';
    public $timestamps = false;

    protected $fillable = [
        'lang',
        'title',
        'keys',
        'description',
        'cuerpo',
        'bienvenida',
        'icono',
        'submenu',
        'footer',
        'background_image',
        'twitter_url',
        'facebook_url',
        'comision_conveniador',
        'comisionista_por_defecto_id',
        'youtube_video',
        'convenio_id',
        'orden',
        'img_pais',
        'img_logo_empresa',
    ];

    public function bancos()
    {
        return $this->hasMany(Banco::class, 'id', 'paise_id');
    }

    public function regiones()
    {
        return $this->hasMany(Region::class, 'paise_id', 'id');
    }

    public function getNombreAttribute()
    {
        return $this->title;
    }

}
