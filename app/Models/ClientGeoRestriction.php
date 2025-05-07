<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientGeoRestriction extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'country_id',
        'state_id',
        'city_id',
    ];
}
