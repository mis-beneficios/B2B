<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;

class Convenio extends Model
{
    protected $table   = 'convenios';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'llave',
        'img',
        'empresa_nombre',
        'welcome',
        'bienvenida_convenio',
        'created',
        'modified',
        'activo_hasta',
        'disponible',
        'nomina',
        'contrato',
        'paise_id',
        'contrato_nomina',
        'convenio_maestro',
        'convenio_bancario',
        'terminos_y_condiciones',
        'comision_conveniador',
        'video',
        'campana_inicio',
        'campana_fin',
        'campana_paquetes',
        'logo',
        'url',
        'grupo',
        'pago',
        'visitas_web',
        'school',
        'img_bienvenida',
        'leyenda_escuelas',
        'titulo_escuelas',
        'salesgroup_id',
        'fecha_cierre',
        'convenio_file',
        'concal_id',
    ];

    public function estancias()
    {
        return $this->hasMany(Estancia::class);
    }

    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    public function clientes()
    {
        return $this->hasMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creado()
    {
        return new Date($this->created);
    }

    public function modificado()
    {
        return new Date($this->modified);
    }

    /**
     * Convenio belongs to Concal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function concal()
    {
        // belongsTo(RelatedModel, foreignKey = concal_id, keyOnRelatedModel = id)
        return $this->belongsTo(Concal::class);
    }

    public function getPaisAttribute()
    {
        switch ($this->paise_id) {
            case 1:
                $pais = 'México';
                break;
            case 7:
                $pais = 'USA';
            default:
                $pais = 'S/R';
                break;
        }

        return $pais;
    }
}
