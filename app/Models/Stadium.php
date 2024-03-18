<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    protected $table = 'stadiums';

    protected $fillable = [
        'name'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function stadiumPrices()
    {
        return $this->hasMany(StadiumPrice::class);
    }
}
