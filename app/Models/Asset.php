<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wallet_id',
        'label',
        'symbol',
        'amount',
        'type',
        'is_veried',
        'value',
    ];

    public function wallet()
    {
        return    $this->belongsTo(Wallet::class);
    }
}
