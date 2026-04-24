<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'name',
        'email',
        'role',
        'rating',
        'text',
        'is_approved',
        'show_on_landing',
        'ip',
         'submitted_at',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'show_on_landing' => 'boolean',
        'rating' => 'integer',
    ];
}
