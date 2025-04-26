<?php

namespace App\Livewire\App\Clients;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\RateLimiter;

class Index extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $showVerified = false;
    public $showRegistered = false;

    protected $queryString = ['search', 'statusFilter', 'showVerified', 'showRegistered'];
    public $client = null;
    public $modal = false;
    public $password; #, $tab;
    public $view_business_card = false;

    public function toggleVerify($id)
    {
        $client = Client::findOrFail($id);
        $client->is_verified = !$client->is_verified;
        $client->save();
    }

    public function toggleRegister($id)
    {
        $client = Client::findOrFail($id);
        $client->is_registered = !$client->is_registered;
        $client->save();
    }
    public function open_view_business_card($id): void
    {
        $this->client = Client::findOrFail(read($id));
        $this->view_business_card = true;
    }
    public function close_view_business_card(): void
    {
        $this->view_business_card = false;
    }
    public function deleteClient($id)
    {
        $this->client = Client::findOrFail($id);
        $this->modal = 'delete';
    }
    public function delete_client_comfirm()
    {
        $key = 'delete-client:' . Auth::id();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->addError('password', 'Too many attempts. Please wait.');
            return;
        }

        RateLimiter::hit($key, 60); // 1-minute decay
        $this->validate([
            'password' => 'required',
        ]);


        if (!Hash::check($this->password, Auth::user()->password)) {
            $this->addError('password', 'Incorrect password.');
            return;
        }

        if ($this->client) {
            $this->client->status = 'terminated';
            $this->client->save();
            $this->alert('success', 'Client deleted successfully.');
            $this->modal = null;
        }
    }

    // public function toggle_c_tab($tab)
    // {
    //     $this->tab = $tab;
    // }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $clients = Client::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->when($this->statusFilter !== 'all', fn($q) => $q->where('status', $this->statusFilter))
            ->when($this->showVerified, fn($q) => $q->where('is_verified', true))
            ->when($this->showRegistered, fn($q) => $q->where('is_registered', true))
            ->with(['owner'])
            ->latest()
            ->paginate(10);

        return view('livewire.app.clients.index', compact('clients'));
    }
}
