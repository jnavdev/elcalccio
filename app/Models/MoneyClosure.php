<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MoneyClosure extends Model
{
    protected $table = 'money_closures';

    protected $fillable = [
        'date',
        'cash_collected_total',
        'cash_real_total',
        'transfer_collected_total',
        'transfer_real_total',
        'debt_collected_total',
        'debt_real_total',
        'credit_collected_total',
        'credit_real_total',
        'user_id',
        'stadium_id',
    ];

    protected $dates = [
        'date',
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
}
