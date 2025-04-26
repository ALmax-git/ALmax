<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    // Define fillable fields
    protected $fillable = [
        'client_id',
        'user_id',
        'name',
        'brand',
        'sub_title',
        'category_id',
        'description',
        'discount',
        'stock_price',
        'sale_price',
        'available_stock',
        'color',
        'size',
        'si_unit',
        'weight',
        'status',
        'sold'
    ];

    /**
     * Relationship with the Client model (a product belongs to a client).
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relationship with the ProductCategory model (a product belongs to a Category).
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Relationship with the User model (a product belongs to a user).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the ProductVariant model (a product can have many variants).
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public function images()
    {
        return File::where('label', $this->id)->where('type', 'product_image')->get();
    }
    // Addons where this product is the base
    public function addons()
    {
        return $this->hasMany(Addon::class, 'base_product_id');
    }

    // Addons where this product is used AS an addon
    public function usedAsAddon()
    {
        return $this->hasMany(Addon::class, 'addon_product_id');
    }
    // Get the total number of sold products
    public function getTotalSoldAttribute()
    {
        return $this->sold + $this->variants()->sum('sold');
    }
    // Get the total number of available products
    public function getTotalAvailableAttribute()
    {
        return $this->available_stock + $this->variants()->sum('available_stock');
    }
    // Get the total number of products
    public function getTotalProductsAttribute()
    {
        return $this->total_available + $this->total_sold;
    }
}
