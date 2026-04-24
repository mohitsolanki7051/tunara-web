<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class ContactMessage extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'contact_messages';

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
         'replies',
    ];
    protected $casts = [
    'is_read'  => 'boolean',
    'replies'  => 'array',
];
}
