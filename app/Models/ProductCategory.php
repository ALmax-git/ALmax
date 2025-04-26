<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    // Define fillable fields
    protected $fillable = [
        'title',
        'status'
    ];

    /**
     * Relationship with the ProductCategory model (a productcategory has many products).
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }

    /**
     * Relationship with the Addon model (a productcategory has many addons).
     */
    public function addons()
    {
        return $this->hasMany(Addon::class);
    }
}
