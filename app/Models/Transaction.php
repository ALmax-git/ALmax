<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'amount',
        'type',
        'status',
        'tx_ref',
        'currency',
        'description',
        'sender_id',
    ];

    protected $casts = [
        'amount' => 'float',
        'type' => 'string',
        'status' => 'string',
    ];

    /**
     * Get the wallet that owns the transaction.
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    /**
     * Get the sender (user) of the transaction.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
