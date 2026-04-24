<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class OtpVerification extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'otp_verifications';

    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'verified',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified'   => 'boolean',
    ];
}
