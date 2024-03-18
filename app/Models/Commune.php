<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    protected $table = 'communes';

    protected $fillable = [
        'name',
        'province_id'
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function proxies()
    {
        return $this->hasMany(Proxy::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
