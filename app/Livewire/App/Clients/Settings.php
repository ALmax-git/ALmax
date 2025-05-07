<?php

namespace App\Livewire\App\Clients;

use App\Models\Role;
use App\Models\User;
use App\Models\UserClient;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Settings extends Component
{
    use LivewireAlert, WithPagination;
    public $search = '';
    public $staff;
    public $password;
    public $add_role_modal = false;
    public $remove_staff_modal = false;
    public $roles = [], $role_id;

    public $profile_modal = false, $profile;

    public function view_profile($id): void
    {
        $this->profile = User::find(read($id));
        $this->profile_modal = true;
    }
    public function close_profile(): void
    {
        $this->profile = null;
        $this->profile_modal = false;
    }
    public function add_role($id)
    {
        $this->staff = User::find(read($id));
        $this->add_role_modal = true;
    }
    public function cancel_add_role()
    {
        $this->add_role_modal = false;
        $this->staff = null;
    }
    public function create_user_role(): void
    {
        if (UserRole::where('user_id', $this->staff->id)->where('client_id', Auth::user()->client_id)->where('role_id', $this->role_id)->first()) {
            $this->alert('info', 'Role already exist on the user');
        } else {
            UserRole::create([
                'user_id' => $this->staff->id,
                'role_id' => $this->role_id,
                'client_id' => Auth::user()->client_id
            ]);
            $this->alert('success', 'Role successfuly assign to ' .  $this->staff->name);
            $this->staff = null;
            $this->add_role_modal = false;
        }
    }
    public function remove_role($role_id, $user_id)
    {
        if (UserRole::where('role_id', read($role_id))->where('user_id', read($user_id))->where('client_id', Auth::user()->client->id)->first()->delete()) {
            $this->alert('success', 'Role Remove Successfully');
        }
    }
    public function remove_staff($id): void
    {
        $this->staff = User::find(read($id));
        $this->remove_staff_modal = true;
    }
    public function cancel_remove_staff(): void
    {
        $this->staff = null;
        $this->remove_staff_modal = false;
    }

    public function confirm_remove_staff()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        if (Hash::check($this->password, auth()->user()->password)) {
            foreach ($this->staff->roles() as $staff_role) {
                $this->remove_role(write($staff_role->id), write($this->staff->id));
            }
            $client_staff = UserClient::where('client_id', Auth::user()->client->id)
                ->where('user_id', $this->staff->id)->where('is_staff', true)->first();
            $client_staff->is_staff = false;
            $client_staff->save();
            $this->alert('success', 'User remove successfully!');
        } else {
            $this->alert('error', 'Incorrect password.');
            return;
        }

        $this->remove_staff_modal = false;
    }

    public function mount(): void
    {
        $this->roles =  Role::where('status', 'active')->orderBy('title')->get();
    }
    public function render()
    {
        $staff_ids = Auth::user()->client->staffs()->pluck('id');
        $staffs = User::whereIn('id', $staff_ids)
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);
        return view('livewire.app.clients.settings', compact('staffs'));
    }
}
