<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empowerment extends Model
{

    protected $fillable = [
        'user_id',
        'target_id',
        'client_id',
        'title',
        'white_paper',
        'status'
    ];

    public function hr()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
