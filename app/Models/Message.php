<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'message_id',
        'sender_id',
        'reciever_id',
        'status',
        'level',
        'content',
    ];
}
