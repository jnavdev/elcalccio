<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'description',
        'price',
        'period',
        'is_active',
        'school_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
