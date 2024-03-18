<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = [
        'order',
        'title',
        'date',
        'url',
        'is_active',
        'for_school'
    ];

    protected $dates = [
        'date'
    ];
}
