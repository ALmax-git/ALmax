<?php

namespace App\Livewire\App\Clients;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class RoleAndPermission extends Component
{
    use LivewireAlert, WithPagination;
    public $search = '';
    public $role,
        $title,
        $description,
        $status,
        $password,
        $is_edit = false;
    public $permission;
    public $role_modal = false;
    public $role_delete_modal = false;
    public $permission_modal = false;
    public $permission_delete_modal = false;
    public $add_permission_modal = false;
    public $permission_id;
    public $label;
    public function add_permission($id)
    {
        $this->role = Role::find(read($id));
        $this->add_permission_modal = true;
    }
    public function create_role_permission(): void
    {
        if (RolePermission::where('permission_id', $this->permission_id)->where('role_id', $this->role->id)->first()) {
            $this->alert('warning', 'This permission is already added to this role');
            return;
        } else {
            $role_permission = new RolePermission();
            $role_permission->role_id = $this->role->id;
            $role_permission->permission_id = $this->permission_id;
            $role_permission->save();
            $this->add_permission_modal = false;
            $this->alert('success', 'Permission added successfully.');
        }
    }
    public function cancel_add_permission(): void
    {
        $this->add_permission_modal = false;
        $this->permission_id = null;
    }
    public function remove_permission($role_id, $permission_id)
    {
        if (RolePermission::where('role_id', read($role_id))->where('permission_id', read($permission_id))->first()->delete()) {
            $this->alert('success', 'Permission Removed successfully.');
        }
    }
    public function open_permission_modal()
    {
        $this->title = '';
        $this->description = '';
        $this->status = '';
        $this->label = '';
        $this->permission_modal = true;
        $this->is_edit = false;
        $this->permission = new Permission();
    }
    public function close_permission_modal(): void
    {
        $this->title = '';
        $this->description = '';
        $this->status = '';
        $this->permission_modal = false;
        $this->label = '';
        $this->is_edit = false;
        $this->permission = null;
    }
    public function edit_permission($id): void
    {
        $this->permission = Permission::find(read($id));
        $this->title = $this->permission->title;
        $this->description = $this->permission->description;
        $this->label = $this->permission->label;
        $this->status = $this->permission->status;
        $this->permission_modal = true;
        $this->is_edit = true;
    }
    public function save_permission(): void
    {
        $this->permission->title = $this->title;
        $this->permission->description = $this->description;
        $this->permission->status = $this->status;
        $this->permission->label = $this->label;
        $this->permission->save();
        $this->permission_modal = false;
        if ($this->is_edit) {
            $this->alert('success', 'Permission Updated Successfully');
        } else {
            $this->alert('success', 'New Permission Created Successfully');
        }
        $this->is_edit = false;
    }
    public function delete_permission($id): void
    {
        $this->permission = Permission::find(read($id));
        $this->permission_delete_modal = true;
    }
    public function cancel_permission_delete(): void
    {
        $this->permission_delete_modal = false;
        $this->permission = null;
    }
    public function confirm_delete_permission()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        if (Hash::check($this->password, auth()->user()->password)) {
            Permission::find($this->permission->id)->update(['status' => 'archived']);
            $this->alert('success', 'Permission deleted successfully!');
            $this->password = '';
        } else {
            $this->alert('error', 'Incorrect password.');
            return;
        }

        $this->permission_delete_modal = false;
    }
    public function open_role_modal()
    {
        $this->title = '';
        $this->description = '';
        $this->status = '';
        $this->role_modal = true;
        $this->is_edit = false;
        $this->role = new Role();
    }
    public function close_role_modal(): void
    {

        $this->title = '';
        $this->description = '';
        $this->status = '';
        $this->role_modal = false;
        $this->is_edit = false;
        $this->role = null;
    }
    public function edit_role($id): void
    {
        $this->role = Role::find(read($id));
        $this->title = $this->role->title;
        $this->description = $this->role->description;
        $this->status = $this->role->status;
        $this->role_modal = true;
        $this->is_edit = true;
    }
    public function save_role(): void
    {
        $this->role->title = $this->title;
        $this->role->description = $this->description;
        $this->role->status = $this->status;
        $this->role->save();
        $this->role_modal = false;
        if ($this->is_edit) {
            $this->alert('success', 'Role Updated Successfully');
        } else {
            $this->alert('success', 'New Role Created Successfully');
        }
        $this->is_edit = false;
    }
    public function delete_role($id): void
    {
        $this->role = Role::find(read($id));
        $this->role_delete_modal = true;
    }
    public function cancel_role_delete(): void
    {
        $this->role_delete_modal = false;
        $this->role = null;
    }
    public function confirm_delete_role()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        if (Hash::check($this->password, auth()->user()->password)) {
            Role::find($this->role->id)->update(['status' => 'archived']);
            $this->alert('success', 'Role deleted successfully!');
            $this->password = '';
        } else {
            $this->alert('error', 'Incorrect password.');
            return;
        }

        $this->role_delete_modal = false;
    }

    public function render()
    {
        $roles = Role::where('title', 'like', '%' . $this->search . '%')->orderBy('title')->paginate(5);
        $permissions =  Permission::where('title', 'like', '%' . $this->search . '%')->orderBy('title')->paginate(5);
        return view('livewire.app.clients.role-and-permission', compact('roles', 'permissions'));
    }
}
