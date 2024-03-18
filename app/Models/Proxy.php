<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    protected $table = 'proxies';

    protected $fillable = [
        'full_name',
        'rut',
        'email',
        'relationship',
        'address',
        'phone',
        'commune_id',
        'student_id'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
