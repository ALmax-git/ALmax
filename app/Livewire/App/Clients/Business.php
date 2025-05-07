<?php

namespace App\Livewire\App\Clients;

use App\Models\Client;
use App\Models\ClientCategory;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Business extends Component
{
    use LivewireAlert, WithPagination;
    public $search = '';
    public $password;
    public $client_category,
        $is_edit = false,
        $title,
        $status,
        $description;
    public $client_category_modal = false, $client_category_delete_modal = false;
    public function reset_fields(): void
    {
        $this->password = '';
        $this->title = '';
        $this->status = null;
        $this->description = '';
    }
    public function confirm_delete_client_category()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            ClientCategory::find($this->client_category->id)->update(['status' => 'terminated']);
            $this->alert('success', 'Client Category deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->client_category_delete_modal = false;
        $this->password = '';
    }
    public function delete_client_category($id)
    {
        $this->client_category_delete_modal = true;
        $this->client_category = ClientCategory::find(read($id));
        $this->reset_fields();
        $this->search = '';
    }

    public function add_client_category_modal()
    {
        $this->client_category_modal = true;
        $this->is_edit = false;
        $this->reset_fields();
    }
    public function edit_client_category_modal($id)
    {
        $this->client_category_modal = true;
        $this->is_edit = true;
        $this->client_category = ClientCategory::find(read($id));
        $this->title = $this->client_category->title;
        $this->status = $this->client_category->status;
        $this->description = $this->client_category->description;
    }
    public function update_client_category()
    {
        $this->client_category->title = $this->title;
        $this->client_category->status = $this->status;
        $this->client_category->description = $this->description;
        $this->client_category->save();
        $this->alert('success', 'Client Category updated Successfully');
        $this->client_category_modal = false;
        $this->is_edit = false;
        $this->reset_fields();
    }
    public function create_client_category()
    {
        if (ClientCategory::Where('title', $this->title)->first()) {
            $this->alert('info', 'Client Category already Exist');
            return;
        }
        $this->client_category = new ClientCategory();
        $this->client_category->title = $this->title;
        $this->client_category->status = $this->status;
        $this->client_category->description = $this->description;
        $this->client_category->save();
        $this->alert('success', 'Client Category created Successfully');
        $this->client_category_modal = false;
        $this->is_edit = false;
    }
    public function render()
    {
        $clients = Client::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('tagline', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(5);
        $categories = ClientCategory::where('title', 'like', '%' . $this->search . '%')
            ->orderBy('title')
            ->paginate(5);
        return view('livewire.app.clients.business', compact('clients', 'categories'));
    }
}
