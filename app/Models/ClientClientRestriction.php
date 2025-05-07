<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientClientRestriction extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'target_id',
    ];
}
