<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'type', // fixed | percentage
        'value',
        'usage_limit', // total times it can be used
        'used_count', // how many times it's used
        'expires_at',
        'status', // active | expired | disabled
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
    protected $attributes = [
        'status' => 'active', // default status
        'used_count' => 0, // default used count
    ];
}
// This model represents a coupon that can be applied to orders.
// It includes fields for the coupon code, type (fixed or percentage), value, usage limit,
// used count, expiration date, and status (active, expired, or disabled).
// The model also includes casts for the expiration date and default values for status and used count.