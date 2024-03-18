<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';

    protected $fillable = [
        'account_number',
        'bank',
        'description',
        'executive_name'
    ];

    public function movements()
    {
        return $this->hasMany(Movement::class);
    }
}
