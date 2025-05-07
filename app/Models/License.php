<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'certificate',
        'user_id',
        'client_id',
        'software_id',
        'key',
        'type',
        'status',
        'activated_at',
        'expires_at'
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function software()
    {
        return $this->belongsTo(Software::class);
    }
}
