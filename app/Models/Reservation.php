<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations';

    protected $fillable = [
        'type',
        'commerce_order',
        'total',
        'advancement',
        'state',
        'payment_media',
        'user_id',
        'stadium_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stadium()
    {
        return $this->belongsTo(Stadium::class);
    }

    public function reservationItems()
    {
        return $this->hasMany(ReservationItem::class);
    }

    public function getTotal()
    {
        $total = 0;

        foreach ($this->reservationItems() as $item) {
            $total += $item->price;
        }

        return $total;
    }

    public function getDiscount()
    {
        $discount = $this->getTotal() - $this->total;

        return ($discount < 0) ? 0 : $discount;
    }
}
