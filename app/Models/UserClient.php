<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserClient extends Model
{
    protected $fillable = [
        'user_id',
        'is_staff',
        'client_id',
    ];
}
