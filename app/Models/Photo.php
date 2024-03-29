<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';

    protected $fillable = [
        'name',
        'album_id'
    ];

    public function album()
    {
        return $this->belongsTo(Album::class);
    }
}
