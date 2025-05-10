<?php

namespace App\Livewire\App;

use App\Models\Client;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Community extends Component
{
    use WithPagination, LivewireAlert;

    public $search = '';
    public $country_id;
    public $state_id;
    public $city_id;
    public $client_id;

    public $email;

    public $countries = [], $states = [], $cities = [];

    // Model References
    public $country, $state;

    protected $updatesQueryString = ['search', 'country_id', 'state_id', 'city_id', 'client_id'];

    public $profile_modal = false;
    public $profile;

    public function mount($email = null): void
    {
        if ($email) {
            $user = User::where('email', $email)->first();
            if ($user) {
                if ($user->visibility != 'public') {
                    $this->alert('info', 'We Could not find the user info you are looking for!');
                } else {
                    $this->view_profile(write($user->id));
                }
            } else {
                $this->alert('warning', 'We Could not find the user info you are looking for!');
            }
        }
        $this->countries = Country::where('status', 'active')->orderBy('name')->get();
    }
    /**
     * Update states when country changes.
     */
    public function change_country($id): void
    {
        if (!$id) {
            return;
        }
        $this->country = Country::findOrFail(read($id));
        $this->country_id = read($id);
        $this->states = $this->country->states()->orderBy('name')->get();
        $this->cities = []; // Reset cities
        $this->state_id = null;
        $this->city_id = null;
    }


    /**
     * Update cities when state changes.
     */
    public function change_state($id): void
    {
        if (!$id) {
            return;
        }
        $this->state = State::findOrFail(read($id));
        $this->state_id = read($id);
        $this->cities = $this->state->cities()->orderBy('name')->get();
        $this->city_id = null;
    }
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
    public function render()
    {
        $query = User::where('visibility', 'public')
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->when($this->country_id, fn($q) => $q->where('country_id', $this->country_id))
            ->when($this->state_id, fn($q) => $q->where('state_id', $this->state_id))
            ->when($this->city_id, fn($q) => $q->where('city_id', $this->city_id))
            ->when($this->client_id, fn($q) => $q->where('client_id', $this->client_id));

        return view('livewire.app.community', [
            'people' => $query->paginate(12),
            'clients' => Client::where('status', 'active')->orderBy('name')->get()
        ]);
    }
}
