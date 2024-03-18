<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $table = 'movements';

    protected $fillable = [
        'date',
        'amount',
        'description',
        'concept_id',
        'payment_method_id'
    ];

    protected $dates = [
        'date'
    ];

    public function concept()
    {
        return $this->belongsTo(Concept::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
