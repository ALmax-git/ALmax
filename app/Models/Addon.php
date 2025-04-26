<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = [
        'base_product_id',
        'addon_product_id',
        'label',
        'required',
        'category_id',
    ];

    protected $casts = [
        'required' => 'boolean',
    ];

    public function baseProduct()
    {
        return $this->belongsTo(Product::class, 'base_product_id');
    }

    public function addonProduct()
    {
        return $this->belongsTo(Product::class, 'addon_product_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
