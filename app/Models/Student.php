<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'class',
        'full_name',
        'profile_picture',
        'rut',
        'birth_date',
        'nationality',
        'address',
        'sex',
        'phone',
        'email',
        'disability',
        'conadis',
        'diseases',
        'medicines',
        'allergies',
        'blood_type',
        'shoe_number',
        'shirt_size',
        'shirt_number',
        'pants_size',
        'height',
        'weight',
        'authorization_file',
        'is_active',
        'commune_id'
    ];

    protected $dates = [
        'birth_date',
        'created_at',
        'updated_at'
    ];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function proxies()
    {
        return $this->hasMany(Proxy::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function scopeBirthDayBetween($query, Carbon $from, Carbon $till)
    {
        $fromMonthDay = $from->format('m-d');
        $tillMonthDay = $till->format('m-d');

        if ($fromMonthDay <= $tillMonthDay) {
            $query->whereRaw("DATE_FORMAT(birth_date, '%m-%d') BETWEEN '{$fromMonthDay}' AND '{$tillMonthDay}'");
        } else {
            $query->where(function ($query) use ($fromMonthDay, $tillMonthDay) {
                $query->whereRaw("DATE_FORMAT(birth_date, '%m-%d') BETWEEN '{$fromMonthDay}' AND '12-31'")
                    ->orWhereRaw("DATE_FORMAT(birth_date, '%m-%d') BETWEEN '01-01' AND '{$tillMonthDay}'");
            });
        }
    }
}
