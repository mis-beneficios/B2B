<?php

namespace App;

use App\Contrato;
use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Date\Date;
use Uuid;
use Illuminate\Support\Facades\DB;
use Log;

// use App\Observers\UserObserver;

class User extends Authenticatable
{
    use Notifiable;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->user_hash = (string) Uuid::generate(4);
        });
    }

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'convenio_id',
        'padre_id',
        'salesgroup_id',
        'username',
        'password',
        'role',
        'manager',
        'created',
        'modified',
        'nombre',
        'apellidos',
        'referido_empresa',
        'rfc',
        'numero_de_empleado',
        'direccion',
        'direccion2',
        'ciudad',
        'pais',
        'telefono',
        'confirmado',
        'provincia',
        'user_hash',
        'usuario_comprador',
        'cumpleanos',
        'codigo_postal',
        'historico',
        'telefono_oficina',
        'telefono_casa',
        'via_contacto_preferida',
        'payment_id',
        'importado',
        'disponible',
        'permitir_login',
        'entrada_1',
        'entrada_2',
        'salida_1',
        'salida_2',
        'lu',
        'ma',
        'mi',
        'ju',
        'vi',
        'sa',
        'do',
        'vetarifah',
        'autreservas',
        'actividades',
        'concurso_dwn',
        'supervisor_convenios',
        'invitaciones',
        'estancia_paise_id',
        'carrera',
        'semestre_grado',
        'tipo_universitario',
        'como_se_entero',
        'consulta_ventas',
        // 'clave',
        'autorizo',
        'alerta_enviada',
        'redes_sociales',
        'system_register',
        'block_card',
        'block_folio',
        'log',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'clave', 'pass_hash',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->pass_hash;
    }

    // public function getAuthEmail()
    // {
    //     return $this->username;
    // }

    public function diffForhumans()
    {
        return Carbon::create($this->created)->diffForHumans();
    }

    public function creado()
    {
        return new Date($this->created);
    }

    //Convertir el atributo password a encriptacion de laravel
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }

    public function getFullNameAttribute()
    {
        return $this->nombre . ' ' . $this->apellidos;
    }

    public function getDireccionCompletaAttribute()
    {
        return $this->direccion . ', ' . 'CP: ' . $this->codigo_postal . ', ' . $this->ciudad . ', ' . $this->provincia;
    }
    public function contratos()
    {
        return $this->hasMany(Contrato::class);
    }

    /**
     * Quien fue el usuario que registro
     */
    public function padre()
    {
        return $this->belongsTo(Padre::class);
    }

    public function admin_padre()
    {
        // return $this->belongsTo(Padre::class, 'user_id');
        return $this->hasOne(Padre::class, 'user_id', 'id');
    }

    public function registrante()
    {
        return $this->belongsTo(Padre::class);
    }

    public function convenio()
    {
        return $this->belongsTo(Convenio::class);
    }

    public function tarjetas()
    {
        return $this->hasMany(Tarjeta::class, 'user_id', 'id');
    }

    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Salesgroup::class, 'salesgroup_id', 'id');
    }

    public function empresas()
    {
        return $this->hasMany(Concal::class);
    }

    public function convenios()
    {
        return $this->hasMany(Convenio::class);
    }

    public function intentos()
    {
        return $this->hasMany(IntentoCompra::class, 'user_id');
    }

    public function config()
    {
        return $this->hasOne(ConfigUser::class);
    }

    /**
     * Incidencia has many User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function incidencias()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = incidencia_id, localKey = id)
        return $this->hasMany(Incidencia::class);
    }

    public function getPerfilAttribute()
    {
        switch ($this->role) {
            case 'admin':
                $rol = 'Administrador';
                break;
            case 'collector':
                $rol = 'Cobranza';
                break;
            case 'control':
                $rol = 'Control';
                break;
            case 'conveniant':
                $rol = 'Conveniador';
                break;
            case 'quality':
                $rol = 'Calidad';
                break;
            case 'recepcionist':
                $rol = 'Recepcionista';
                break;
            case 'reserver':
                $rol = 'Reservaciones';
                break;
            case 'sales':
                $rol = 'Ejecutivo';
                break;
            case 'supervisor':
                $rol = 'Supervisor';
                break;

            default:
                $rol = 'Cliente';
                break;
        }

        return $rol;
    }

    public function getLoginAttribute()
    {
        if ($this->permitir_login == 1) {
            $res = __('messages.activo');
        } else {
            $res = __('messages.inactivo');
        }
        return $res;
    }

    public function getLogUserAttribute()
    {
        if ($this->log != null) {
            return Markdown::convertToHtml($this->log);
        } else {
            return 'Sin registros';
        }
    }

    public function notificaciones()
    {
        return $this->hasMany(Comment::class);
    }

    public function calidades()
    {
        return $this->hasMany(Imagen::class);
    }

    /**
     * Equipo de ventas informacion
     */
    public function mis_clientes()
    {
        return $this->where(['padre_id' => $this->admin_padre->id, 'role' => 'client'])->count();
    }

    public function mis_contratos()
    {
        return Contrato::where(['padre_id' => $this->admin_padre->id])->whereIn('estatus', ['comprado', 'viajado', 'pagado'])->count();
    }

    public function comisiones_pagables()
    {
        return Comision::where(['user_id' => $this->id, 'pagable' => true])->sum('cantidad');

    }
    public function comisiones_generadas()
    {
        return Comision::where(['user_id' => $this->id])->sum('cantidad');
    }

    public function supervisor()
    {
        return Salesgroup::where('user_id', $this->id)->first();
    }

    public function job_notificacion()
    {
        return $this->hasMany(JobNotifications::class);
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'user_id', 'id');
    }

    public function sp_clientes_porUsuario($id_usuario) 
    {
        $response['data']=DB::select('CALL sp_clientes_porUsuario(?,@success, @message, @log)', [$id_usuario]);
        $response['success']=DB::select('SELECT @success AS success')[0]->success;
        $response['message']=DB::select('SELECT @message AS message')[0]->message;
        $response['log']=DB::select('SELECT @log AS log')[0]->log;
        $response=json_decode(json_encode($response), true);
        //Log::debug("response  sp_clientes_porUsuario :: ".print_r($response,1));
        return $response;
    }
    
}
