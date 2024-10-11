<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigUser extends Model
{
    use HasFactory;

    protected $table = 'config_user';

    protected $fillable = [
        'id',
        'user_id',
        'type',
        'host',
        'port',
        'email',
        'password',
        'encryption',
        'from',
        'from_name',
        'config',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
