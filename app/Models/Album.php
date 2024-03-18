<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $table = 'albums';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'date',
        'is_active'
    ];

    protected $dates = [
        'date'
    ];

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
