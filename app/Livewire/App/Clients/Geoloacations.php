<?php

namespace App\Livewire\App\Clients;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Geoloacations extends Component
{
    use WithPagination, LivewireAlert;

    public $searchTerm = '';
    public $status = 'active';
    public $selectedCountry;
    public $selectedState;
    public $cityName;
    public $postalCode;
    public $statusToggle = false;
    public $password;
    public $deleteId;
    public $isEditing = false;
    public $editId;
    public $modalOpen = false;
    public $city = null;
    public $city_modal = false;
    public $state = null;
    public $state_modal = false;
    public $state_name = '';
    public $state_delete_modal = false;
    public $tab = 'City';

    public $country_name, $code, $flag, $iso2, $iso3, $currency;
    public $country_modal = false;
    public $country_delete_modal = false;

    public function add_country_modal()
    {
        $this->country_modal = true;
        $this->isEditing = false;
        $this->resetInputFields();
    }
    public function update_links()
    {
        $this->resetPage();
    }

    public function add_country()
    {
        $this->validate([
            'country_name' => 'required|string|min:3',
            'code' => 'required|string|min:2|max:5',
            'iso2' => 'nullable|string|max:2',
            'iso3' => 'nullable|string|max:3',
            'flag' => 'nullable|string',
            'currency' => 'nullable|string|max:5',
            'statusToggle' => 'boolean',
        ]);

        Country::create([
            'name' => $this->country_name,
            'code' => $this->code,
            'flag' => $this->flag,
            'iso2' => $this->iso2,
            'iso3' => $this->iso3,
            'currency' => $this->currency,
            'status' => $this->statusToggle ? 'active' : 'inactive',
        ]);

        $this->resetInputFields();
        $this->country_modal = false;
        $this->alert('success', 'Country added successfully!');
    }

    public function edit_country($id)
    {
        $country = Country::findOrFail(read($id));

        $this->editId = $country->id;
        $this->country_name = $country->name;
        $this->code = $country->code;
        $this->flag = $country->flag;
        $this->iso2 = $country->iso2;
        $this->iso3 = $country->iso3;
        $this->currency = $country->currency;
        $this->statusToggle = $country->status === 'active';

        $this->isEditing = true;
        $this->country_modal = true;
    }

    public function update_country()
    {
        $this->validate([
            'country_name' => 'required|string|min:3',
            'code' => 'required|string|min:2|max:5',
            'iso2' => 'nullable|string|max:2',
            'iso3' => 'nullable|string|max:3',
            'flag' => 'nullable|string',
            'currency' => 'nullable|string|max:5',
            'statusToggle' => 'boolean',
        ]);

        $country = Country::findOrFail($this->editId);
        $country->update([
            'name' => $this->country_name,
            'code' => $this->code,
            'flag' => $this->flag,
            'iso2' => $this->iso2,
            'iso3' => $this->iso3,
            'currency' => $this->currency,
            'status' => $this->statusToggle ? 'active' : 'inactive',
        ]);

        $this->resetInputFields();
        $this->isEditing = false;
        $this->country_modal = false;
        $this->alert('success', 'Country updated successfully!');
    }

    public function delete_country($id)
    {
        $this->deleteId = $id;
        $this->country_delete_modal = true;
        $this->password = '';
        $this->alert('warning', 'Confirm your password to delete this country.');
    }

    public function confirm_delete_country()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        if (Hash::check($this->password, auth()->user()->password)) {
            Country::destroy($this->deleteId);
            $this->alert('success', 'Country deleted successfully!');
            $this->resetPassword();
        } else {
            $this->alert('error', 'Incorrect password.');
            return;
        }

        $this->country_delete_modal = false;
    }


    public function add_state()
    {
        $this->validate([
            'state_name' => 'required|string|min:3',
            'selectedCountry' => 'required|exists:countries,id',
            'statusToggle' => 'boolean',
        ]);

        State::create([
            'name' => $this->state_name,
            'status' => $this->statusToggle ? 'active' : 'inactive',
            'country_id' => $this->selectedCountry,
        ]);

        $this->resetInputFields();
        $this->alert('success', 'City added successfully!');
        $this->state_modal = false;
    }
    public function add_state_modal()
    {
        $this->state_modal = true;
        $this->isEditing = false;
        $this->resetInputFields();
        $this->state_name = '';
        $this->selectedState = null;
    }

    public function edit_state($id)
    {
        $this->state = State::find(read($id));
        $this->state_modal = true;
        $this->isEditing = true;

        $this->editId = $this->state->id;
        $this->state_name = $this->state->name;
        $this->statusToggle = $this->state->status == 'active';
        $this->selectedCountry = $this->state->country_id;
    }

    public function update_state()
    {
        $this->validate([
            'state_name' => 'required|string|min:3',
            'selectedCountry' => 'required|exists:countries,id',
            'statusToggle' => 'boolean',
        ]);

        $state = State::find($this->editId);
        $state->update([
            'name' => $this->state_name,
            'status' => $this->statusToggle ? 'active' : 'inactive',
            'country_id' => $this->selectedCountry,
        ]);

        $this->resetInputFields();
        $this->isEditing = false;
        $this->alert('success', 'State updated successfully!');
        $this->state_modal = false;
    }

    public function delete_state($id)
    {
        $this->state = State::where('id', read($id))->first();
        $this->deleteId = $this->state->id;
        $this->state_delete_modal = true;
        $this->password = '';
        $this->alert('warning', 'Please confirm your password to delete this city.');
    }

    public function confirm_delete_state()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            State::destroy($this->deleteId);
            $this->alert('success', 'State deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->state_delete_modal = false;
        $this->resetPassword();
    }
    public function switchTab($tab)
    {
        $this->tab = $tab;
        // $this->resetPage(); // resets pagination
        $this->update_links();
        // $this->reset();
    }

    public function render()
    {
        $countries = Country::query()
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('code', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('name')
            ->paginate(5);

        $states = State::query()
            ->where('country_id', $this->selectedCountry ?? 1)
            ->orderBy('name')
            ->paginate(5);

        $cities = City::query()
            ->where('state_id', $this->selectedState)
            ->where('status', $this->status)
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->orWhere('postal_code', 'like', '%' . $this->searchTerm . '%')
            ->orderBy('name')
            ->paginate(5);

        return view('livewire.app.clients.geoloacations', compact('countries', 'states', 'cities'));
    }

    public function addCity()
    {
        $this->validate([
            'cityName' => 'required|string|min:3|unique:cities,name,NULL,id,country_id,' . $this->selectedCountry,
        ]);
        $this->validate([
            // 'cityName' => 'required|string|min:3',
            'postalCode' => 'required|string|max:10',
            'selectedCountry' => 'required|exists:countries,id',
            'selectedState' => 'required|exists:states,id',
            'statusToggle' => 'boolean',
        ]);

        City::create([
            'name' => $this->cityName,
            'postal_code' => $this->postalCode,
            'status' => $this->statusToggle ? 'active' : 'inactive',
            'state_id' => $this->selectedState,
            'country_id' => $this->selectedCountry,
        ]);

        $this->resetInputFields();
        $this->alert('success', 'City added successfully!');
        $this->city_modal = false;
    }
    public function addCityModal()
    {
        $this->city_modal = true;
        $this->isEditing = false;
        $this->resetInputFields();
        $this->selectedCountry = null;
        $this->selectedState = null;
    }

    public function edit_city($id)
    {
        $this->city = City::find(read($id));
        $this->city_modal = true;
        $this->isEditing = true;
        $this->editId = $this->city->id;
        $this->cityName = $this->city->name;
        $this->postalCode = $this->city->postal_code;
        $this->statusToggle = $this->city->status == 'active';
        $this->selectedState = $this->city->state_id;
        $this->selectedCountry = $this->city->country_id;
    }

    public function updateCity()
    {
        $this->validate([
            'cityName' => 'required|string|min:3',
            'postalCode' => 'required|string|max:10',
            'selectedCountry' => 'required|exists:countries,id',
            'selectedState' => 'required|exists:states,id',
            'statusToggle' => 'boolean',
        ]);

        $city = City::find($this->editId);
        $city->update([
            'name' => $this->cityName,
            'postal_code' => $this->postalCode,
            'status' => $this->statusToggle ? 'active' : 'inactive',
            'state_id' => $this->selectedState,
            'country_id' => $this->selectedCountry,
        ]);

        $this->resetInputFields();
        $this->isEditing = false;
        $this->alert('success', 'City updated successfully!');
        $this->city_modal = false;
    }

    public function deleteCity($id)
    {
        // dd($id);
        $this->city = City::find(read($id));
        $this->deleteId = $this->city->id;
        $this->modalOpen = true;
        $this->password = '';
        $this->alert('warning', 'Please confirm your password to delete this city.');
    }

    public function confirmDelete()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            City::destroy($this->deleteId);
            $this->alert('success', 'City deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->modalOpen = false;
        $this->resetPassword();
    }

    private function resetInputFields()
    {
        $this->cityName = '';
        $this->postalCode = '';
        $this->statusToggle = false;
        $this->country_name = '';
        $this->code = '';
        $this->flag = '';
        $this->iso2 = '';
        $this->iso3 = '';
        $this->currency = '';
        $this->statusToggle = true;
        $this->editId = null;
        $this->resetPage(); // resets pagination to page 1 when tab is changed
    }

    private function resetPassword()
    {
        $this->password = '';
    }
}
