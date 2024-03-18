<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StadiumPrice extends Model
{
    protected $table = 'stadium_prices';

    protected $fillable = [
        'hour',
        'price',
        'is_weekend',
        'stadium_id'
    ];

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }
}
