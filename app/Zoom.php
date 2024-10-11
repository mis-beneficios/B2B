<?php

namespace App;

use Exception;
use Illuminate\Database\Eloquent\Model;
use App\User;
use Carbon\Carbon;

class Zoom extends Model
{

    protected $table = 'meetings';

    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'meeting_id',
        'url',
        'start_url',
        'join_url',
        'estatus',
        'fecha',
        'duracion',
        'topic',
        'agenda',
        'host_id',
        'password',
        'compartir',
        'delete_at',
    ];

    public function __construct()
    {
        Carbon::setLocale('es');
        setlocale(LC_ALL, "es_ES");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
