<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;

class Concal extends Model
{
    protected $table    = 'concals';
    public $timestamps  = false;
    protected $fillable = [
        'user_id',
        'username',
        'paise_id',
        'estatus',
        'estado',
        'created',
        'modified',
        'empresa',
        'telefonos',
        'contacto',
        'email',
        'observaciones',
        'no_empleados',
        'primer_llamada',
        'ultima_llamada',
        'siguiente_llamada',
        'pagina_web',
        'log',
        'calificacion',
        'asistente',
        'asistente_email',
        'asistenten_telefono',
        'conmutador',
        'nextel',
        'corporativo',
        'redes',
        'isDelete',
        'sucursales',
        'sucursal_lugar',
        'autoriza_logo',
        'metodo_pago',
        'estrategia',
        'puesto_contacto',
        'giro',
        'categoria',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function color_estatus()
    {
        switch ($this->estatus) {
            case 'cerrado':
                $color = '#5C5C5C';
                break;
            case 'ellos_llaman':
                $color = '#53007D';
                break;
            case 'enviada':
                $color = '#F59B00';
                break;
            case 'interesado':
                $color = '#165e6c';
                break;
            case 'no_contactado':
                $color = '#fd7e14';
                break;
            case 'por_cerrar':
                $color = '#8E0000';
                break;
            case 'rechazada':
                $color = '#f62d51';
                break;
            case 'retomar':
                $color = '#000';
                break;
            case 'seguimiento':
                $color = '#007bff';
                break;
            default:
                $color = '#007bff';
                break;
        }
        return $color;
    }

    public function getLogConcalAttribute()
    {
        if ($this->log != null) {
            return Markdown::convertToHtml($this->log);
        } else {
            return '';
        }
    }

    public function convenio()
    {
        return $this->hasOne(Convenio::class);
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'concal_id', 'id')->orderBy('id', 'DESC');
    }
}
