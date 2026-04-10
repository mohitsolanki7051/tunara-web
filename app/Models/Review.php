<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'name',
        'role',
        'rating',
        'text',
        'is_approved',
        'show_on_landing',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'show_on_landing' => 'boolean',
        'rating' => 'integer',
    ];
}
