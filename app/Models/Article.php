<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'date'
    ];

    protected $dates = [
        'date'
    ];

    public function scopeTitle($query, $title)
    {
        if ($query) {
            return $query->where('title', 'LIKE', '%'.$title.'%');
        }
    }

    public function getTranslatedDate()
    {
        $translatedMonth = getMonthName($this->date->format('F'));

        return $this->date->format('d') . ' ' . $translatedMonth . ' ' . $this->date->format('Y');
    }
}
