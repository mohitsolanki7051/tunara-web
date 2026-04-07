<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PlanSetting extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'plan_settings';

    protected $fillable = [
        'plan',
        'max_tunnels',
        'max_requests_per_day',
        'has_custom_subdomain',
        'has_password_protection',
        'price',
        'is_active',
    ];

    protected $casts = [
        'has_custom_subdomain'    => 'boolean',
        'has_password_protection' => 'boolean',
        'is_active'               => 'boolean',
        'max_tunnels'             => 'integer',
        'max_requests_per_day'    => 'integer',
        'price'                   => 'float',
    ];
}
