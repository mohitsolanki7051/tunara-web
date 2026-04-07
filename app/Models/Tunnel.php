<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Tunnel extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tunnels';

    protected $fillable = [
        'user_id',
        'token_id',
        'tunnel_id',
        'local_url',
        'is_active',
        'password',       
        'is_protected',
    ];
}
