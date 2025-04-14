<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{

    protected $fillable = [
        'label',
        'path',
        'description',
        'visibility',
        'info',
        'mimes',
        'type',
        'user_id',
        'client_id',
    ];
    public function user()
    {
        $this->belongsTo(User::class, 'user_id');
    }
}
