<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    // Define fillable fields
    protected $fillable = [
        'product_id',
        'size',
        'color',
        'si_unit',
        'weight',
        'stock_price',
        'sale_price',
        'available_stock',
        'sold',
    ];

    /**
     * Relationship with the Product model (a variant belongs to a product).
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
