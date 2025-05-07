<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'organizer_id',
        'client_id',
        'title',
        'description',
        'location',
        'start_time',
        'end_time',
        'type',
        'price',
        'status',
        'starting_day',
        'closing_day'
    ];

    protected $casts = [
        'starting_day' => 'datetime',
        'closing_day' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }


    /**
     * Relationship with the Client model (a event belongs to a client).
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function tickets()
    {
        return $this->hasMany(EventTicket::class);
    }

    public function payments()
    {
        return $this->hasMany(TicketPayment::class);
    }
}
