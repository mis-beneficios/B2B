<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Date\Date;
use Carbon\Carbon;
class Reservacion extends Model
{
    protected $table    = 'reservaciones';
    public $timestamps  = false;
    protected $fillable = [
        "id",
        "title",
        "user_id",
        "convenio_id",
        "estancia_id",
        "regione_id",
        "padre_id",
        "created",
        "modified",
        "estatus",
        "destino",
        "clave",
        "notas",
        "notas_admin",
        "tarjeta_id",
        "fecha_de_ingreso",
        "fecha_de_salida",
        "nombre_de_quien_sera_la_reservacion",
        "fecha_limite_de_pago",
        "cantidad",
        "detalle",
        "admin_fecha_para_liquidar",
        "hotel",
        "tarifa",
        "contacto",
        "log",
        "habitaciones",
        "direccion",
        "entrada",
        "salida",
        "revisada",
        "pagada",
        "fecha_de_pago",
        "cantidad_pago",
        "garantizada",
        "garantia",
        "fecha_de_pago_1",
        "fecha_de_pago_2",
        "fecha_de_pago_3",
        "cantidad_pago_1",
        "cantidad_pago_2",
        "cantidad_pago_3",
        "tipo",
        "telefono",
        "email",
        "noches",
        "dias"
    ];

    // public function contratos()
    // {
    //     return $this->hasMany(ContratosReservaciones::class, 'reservacione_id', 'id')->orderBy('id', 'asc');
    // }

    public function creado()
    {
        return new Date($this->created);
    }

    public function estancias()
    {
        return $this->hasOne(Estancia::class);
    }

    public function r_habitaciones()
    {
        return $this->hasMany(Habitacion::class, 'reservacione_id')->orderBy('id', 'ASC');
    }

    // public function r_contratos()
    // {
    //     return $this->belongsToMany(Contrato::class, 'contratos_reservaciones', 'reservacione_id', 'contrato_id');
    // }


    /*
     * Autor: ISW Diego Enrique Sanchez
     * Creado: 2023-05-03
     * Descripcion: Relacion muchos a muchos para contratos y reservaciones asociados
     */
    public function contratos()
    {
        return $this->belongsToMany(Contrato::class, 'contratos_reservaciones', 'reservacione_id','contrato_id');
    }


    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLogReservacionAttribute()
    {
        if ($this->notas != null) {
            return Markdown::convertToHtml($this->notas); // <p>foo</p>
        } else {
            return '';
        }
    }

    public function estancia()
    {
        return $this->belongsTo(Estancia::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function color_estatus()
    {

        switch ($this->estatus) {
            case 'Autorizada':
                $color = '#3ebef3';
                break;
            case 'Cancelada':
                $color = '#ff3636';
                break;
            case 'Cupon Enviado':
                $color = '#F59B00';
                break;
            case 'En proceso':
                $color = '#03eb48';
                break;
            case 'Ingresada':
                $color = '#d4db00';
                break;
            case 'Nuevo':
                $color = '#8f8f8f';
                break;
            case 'Penalizada':
                $color = '#fb5428';
                break;
            case 'Revision':
                $color = '#3228fb';
                break;
            case 'Seguimiento':
                $color = '#fbbf3d';
                break;
            default:
                $color = '#007bff';
                break;
        }
        return $color;
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'regione_id');
    }

    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    public function num_noches()
    {
        return ($this->noches != null) ? $this->noches : Carbon::parse($this->fecha_de_ingreso)->diffInDays(Carbon::parse($this->fecha_de_salida));
    }


    public function num_dias()
    {
        return ($this->dias != null) ? $this->dias : Carbon::parse($this->fecha_de_ingreso)->diffInDays(Carbon::parse($this->fecha_de_salida)) + 1;
    }
}
