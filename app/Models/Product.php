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
}
