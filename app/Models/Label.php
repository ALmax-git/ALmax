<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    /*
    */
    protected $fillable = [
        'product_id',
        'variant_id', // nullable
        'qr_key',     // unique key
        'serial_number', // optional but recommended
        'status',     // active, inactive, sold, reserved
    ];

    protected $casts = [
        'product_id' => 'integer',
        'variant_id' => 'integer',
        'qr_key' => 'string',
        'serial_number' => 'string',
        'status' => 'string',
    ];
    protected $attributes = [
        'status' => 'active', // default status
    ];

    public $timestamps = true;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
