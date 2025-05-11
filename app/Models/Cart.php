<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
        'price',
        'total',
        'status',
        'reservation_end_time',
        'paid_amount',
        'installment_balance',
        'is_selected'
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the product associated with the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant associated with the cart.
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }


    /**
     * Calculate the remaining balance for the installment plan.
     */
    public function getRemainingBalanceAttribute()
    {
        return $this->installment_balance - $this->paid_amount;
    }

    /**
     * Scope to filter carts by status.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeAbandoned($query)
    {
        return $query->where('status', 'abandoned');
    }

    /**
     * Check if the cart is reserved and expired.
     */
    public function isReservationExpired()
    {
        return $this->reservation_end_time && $this->reservation_end_time < now();
    }

    /**
     *
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'item_id');
    }
}
