<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'client_id',
        'label',
        'address',
        'balance',
        'pin',
        'status',
        'type', # client or user
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
