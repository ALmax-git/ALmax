<?php

namespace App\Livewire\App;

use App\Models\Client as ModelsClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Client extends Component
{
    use LivewireAlert;
    public ModelsClient $client;
    public $view_business_card = false;
    public $confirm_activation = false;
    public $password;

    public function open_view_business_card(): void
    {
        $this->view_business_card = true;
    }
    public function close_view_business_card(): void
    {
        $this->view_business_card = false;
    }
    public function init_client_activation(): void
    {
        $this->confirm_activation = true;
    }
    public function cancel_client_activation(): void
    {
        $this->confirm_activation = false;
    }
    public function activate_client_account(): void
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            $this->client->update([
                'status' => 'under_review'
            ]);
            $this->alert('success', 'you account is successfull Activated!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }
    }



    public function mount()
    {
        $this->client = ModelsClient::find(Auth::user()->client_id);
    }
    public function render()
    {
        return view('livewire.app.client');
    }
}
