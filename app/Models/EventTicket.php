<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'used_at',
        'qr_key'
    ];

    protected $casts = [
        'used_at' => 'datetime',
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
