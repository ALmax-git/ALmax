<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletAsset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'wallet_id',
        'asset_id',
        'amount',
    ];

    public function origin()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id');
    }
}
