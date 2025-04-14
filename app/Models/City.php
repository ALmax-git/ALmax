<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'postal_code',
        'status',
        'state_id',
        'country_id'
    ];

    public function country()
    {
        return   $this->belongsTo(Country::class, 'country_id');
    }
    public function state()
    {
        return  $this->belongsTo(State::class);
    }
}
