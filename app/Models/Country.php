<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'code',
        'flag',
        'iso2',
        'iso3',
        'currency',
        'status',
    ];

    public function states()
    {
        return  $this->hasMany(State::class)->where('status', 'active');
    }
}
