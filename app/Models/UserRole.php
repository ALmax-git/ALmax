<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = [
        'user_id',
        'role_id',
        'client_id'
    ];
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
