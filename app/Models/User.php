<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'surname',
        'last_name',
        'phone_number',
        'country_id',
        'state_id',
        'city_id',
        'bio',
        'profile_photo_path',
        'client_id',
        'language',
        'visibility'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function tasks()
    {
        return $this->hasMany(Todo::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'user_clients')
            ->where(function ($query) {
                $query->where('status', 'verified')
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('status', '!=', 'terminated')
                            ->where('user_clients.user_id', $this->id);
                    });
            });
    }
    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function cart_items()
    {
        return $this->hasMany(Cart::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function selected_cart_items()
    {
        return $this->hasMany(Cart::class)->where('is_selected', true);
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id')->where('type', 'user');
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
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->where('roles.status', 'active')
            ->where('user_roles.client_id', Auth::user()->client->id);
    }
    public function white_papers()
    {
        return $this->hasMany(Empowerment::class, 'target_id')->where('empowerments.status', 'pending');
    }
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'target_id');
    }
    public function sentTransactions()
    {
        return $this->hasMany(Transaction::class, 'sender_id');
    }

    public function event_tickets()
    {
        return $this->hasMany(EventTicket::class);
    }
}
