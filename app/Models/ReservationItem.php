<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    protected $table = 'reservation_items';

    protected $fillable = [
        'hour',
        'date',
        'price',
        'reservation_id'
    ];

    protected $dates = [
        'date', 'created_at', 'updated_at'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }
}
