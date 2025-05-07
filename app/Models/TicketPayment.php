<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPayment extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'reference',
        'internal_ref',
        'amount',
        'currency',
        'status',
        'meta'
    ];

    protected $casts = [
        'amount' => 'double',
        'meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
