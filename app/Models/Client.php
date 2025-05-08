<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'logo',
        'email',
        'tagline',
        'telephone',
        'country_id',
        'state_id',
        'city_id',
        'vision',
        'mission',
        'overview',
        'description',
        'is_registered',
        'is_verified',
        'status',
        'user_id',
        'category_id',
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function logo()
    {
        if ($this->logo) {
            // $logos = is_array($this->logo) ? $this->logo : json_decode($this->logo, true);
            return 'storage/' . $this->logo ?? 'default.png';
        }

        $file = File::where('type', 'business_logo')->where('client_id', $this->id)->first();
        return $file ? asset('storage/' . $file->path) : asset('default.png');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function files()
    {
        return $this->hasMany(File::class, 'client_id');
    }
    public function category()
    {
        return $this->belongsTo(ClientCategory::class, 'category_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_clients');
    }
    public function staffs()
    {
        $staffs_ids = UserClient::where('client_id', Auth::user()->client_id)->where('is_staff', true)->pluck('user_id');
        $staffs = User::whereIn('id', $staffs_ids)->orderBy('name')->get();
        return $staffs;
    }
    /**
     * Relationship with the Product model (a client has many products).
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function available_products()
    {
        return $this->hasMany(Product::class)->where('available_stock', '>=', 1);
    }
    public function white_papers()
    {
        return $this->hasMany(Empowerment::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id')->where('type', 'client');
    }
}
