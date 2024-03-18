<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'image',
        'title',
        'slug',
        'description',
        'stock',
        'is_active',
        'product_category_id'
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productInventory()
    {
        return $this->hasOne(ProductInventory::class)->latest();
    }
}
