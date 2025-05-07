<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{
    use LivewireAlert;
    public $category_id = null, $country_id = null, $state_id = null, $city_id = null;
    public $countries = [], $states = [], $cities = [];
    // Model References
    public $country, $state, $client;

    public $telephone, $first_name, $surname, $last_name, $bio, $visibility;
    public function mount()
    {
        $this->countries = Country::where('status', 'active')->orderBy('name')->get();
        $user = User::find(Auth::user()->id);
        $this->first_name = $user->first_name;
        $this->surname = $user->surname;
        $this->last_name = $user->last_name;
        $this->telephone = $user->phone_number;
        $this->country_id = $user->country_id;
        $this->state_id = $user->state_id;
        $this->city_id = $user->city_id;
        $this->bio = $user->bio;
        $this->visibility = $user->visibility;
        if ($user->country_id) {
            $this->change_country(write($user->country_id));
        }
        if ($user->state_id) {
            $this->change_state(write($user->state_id));
            $this->city_id = $user->city_id;
        }
    }
    public function update_profile()
    {
        $user = User::find(Auth::user()->id);
        $user->first_name = $this->first_name;
        $user->surname = $this->surname;
        $user->last_name = $this->last_name;
        $user->phone_number = $this->telephone;
        $user->country_id = $this->country_id;
        $user->state_id = $this->state_id;
        $user->city_id = $this->city_id;
        $user->bio = $this->bio;
        $user->visibility = $this->visibility;


        $user->save();
        $this->alert('success', 'profile updated successfully');
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

    public function render()
    {
        return view('livewire.forms.profile');
    }
}
