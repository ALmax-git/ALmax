<?php

namespace App\Models;

use App\Livewire\Auth\Auth;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id')->where('permissions.status', 'active');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles')
            ->where('user_roles.client_id', Auth::user()->client->id);
        // ->where(function ($query) {
        //     $query->Where(function ($subQuery) {
        //         $subQuery
        //             // ->where('user_roles.user_id', '!=', 'terminated')
        //         ;
        //     });
        // });
    }
}
