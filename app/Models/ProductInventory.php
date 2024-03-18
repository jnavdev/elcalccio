<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    protected $table = 'product_inventory';

    protected $fillable = [
        'cost_price',
        'sale_price',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
