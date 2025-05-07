<?php

namespace App\Livewire\Forms\Create;

use App\Models\Client as ModelsClient;
use App\Models\ClientCategory;
use App\Models\Country;
use App\Models\State;
use App\Models\File;
use App\Models\User;
use App\Models\UserClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Client extends Component
{
    use WithFileUploads, LivewireAlert;

    // Form Inputs
    public string $name = '', $email = '', $tagline = '', $telephone = '';
    public string $vision = '', $mission = '', $description = '';
    public bool $is_edit = false;
    public $logo; // File upload
    public $category_id = null, $country_id = null, $state_id = null, $city_id = null;

    // Dropdown Data
    public $business_categories = [];
    public $countries = [], $states = [], $cities = [];

    // Model References
    public $country, $state, $client;

    /**
     * Mount the component and preload data.
     */
    public function mount($client = null): void
    {
        if ($client && $client instanceof ModelsClient) {
            $this->client = $client;
            $this->name = $client->name;
            $this->email = $client->email;
            $this->tagline = $client->tagline  ?? '';
            $this->telephone = $client->telephone;
            $this->category_id = $client->category_id;
            $this->vision = $client->vision ?? '';
            $this->mission = $client->mission ?? '';
            $this->country_id = $client->country_id ?? 1;
            $this->change_country(write($client->country_id ?? 1));
            $this->state_id = $client->state_id ?? 1;
            $this->change_state(write($client->state_id ?? 1));
            $this->city_id = $client->city_id ?? 1;
            $this->description = $client->description  ?? '';
            $this->is_edit = true;
        }
        $this->business_categories = ClientCategory::orderBy('title')->get();
        $this->countries = Country::where('status', 'active')->orderBy('name')->get();
    }

    /**
     * Renders the Livewire view.
     */
    public function render()
    {
        return view('livewire.forms.create.client');
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

    /**
     * Validate and create a new Client.
     */
    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'tagline' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'category_id' => 'required|exists:client_categories,id',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'description' => 'required|string',
            'logo' => 'required|image|max:2048',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
        ]);

        DB::beginTransaction();

        try {
            $file_name = null;

            // Handle logo upload if exists
            if ($this->logo) {
                $file_name = $this->logo->store('logo', 'public');
            }

            // Create Client
            $this->client = ModelsClient::create([
                'name' => $this->name,
                'email' => $this->email,
                'tagline' => $this->tagline,
                'telephone' => $this->telephone,
                'category_id' => $this->category_id,
                'vision' => $this->vision,
                'mission' => $this->mission,
                'description' => $this->description,
                'logo' => $file_name,
                'country_id' => $this->country_id,
                'state_id' => $this->state_id,
                'city_id' => $this->city_id,
                'user_id' => Auth::id(),
            ]);

            // Save file metadata if logo uploaded
            if ($file_name) {
                File::create([
                    'label' => $file_name,
                    'path' => $file_name,
                    'visibility' => 'protected',
                    'mimes' => $this->logo->getMimeType(),
                    'type' => 'business_logo',
                    'info' => json_encode([
                        'size' => $this->logo->getSize(),
                        'original_name' => $this->logo->getClientOriginalName(),
                        'mimes' => $this->logo->getMimeType(),
                        'type' => $this->logo->getClientOriginalExtension(),
                    ]),
                    'user_id' => Auth::id(),
                    'client_id' => $this->client->id,
                ]);
            }

            // Create UserClient relationship
            UserClient::firstOrCreate([
                'user_id' => Auth::id(),
                'is_staff' => true,
                'client_id' => $this->client->id,
            ]);

            DB::commit();

            $this->alert('success', 'Client created successfully!');
            return redirect()->route('app');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            $this->alert('error', 'Something went wrong while creating the client.');
            return back();
        }
    }
    /**
     * Update existing Client.
     */
    public function update()
    {
        $this->validate([
            // 'name' => 'required|string|max:255',
            // 'email' => 'required|email|max:255',
            // 'tagline' => 'required|string|max:255',
            // 'telephone' => 'required|string|max:255',
            // 'category_id' => 'required|exists:client_categories,id',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'description' => 'required|string',
            // 'logo' => 'nullable|image|max:2048', // Optional for update
            // 'country_id' => 'required|exists:countries,id',
            // 'state_id' => 'required|exists:states,id',
            // 'city_id' => 'required|exists:cities,id',
        ]);

        DB::beginTransaction();
        // Create UserClient relationship
        // UserClient::firstOrCreate([
        //     'user_id' => Auth::id(),
        //     'is_staff' => true,
        //     'client_id' => $this->client->id,
        // ]);
        try {
            // Handle logo upload if exists
            if ($this->logo) {
                $file_name = $this->logo->store('logo', 'public');
                $this->client->update(['logo' => $file_name]);
                File::where('client_id', $this->client->id)->first()->update(['path' => $file_name]);
            }

            // Update Client
            $this->client->update([
                // 'name' => $this->name,
                // 'email' => $this->email,
                // 'tagline' => $this->tagline,
                // 'telephone' => $this->telephone,
                // 'category_id' => $this->category_id,
                'vision' => $this->vision,
                'mission' => $this->mission,
                'description' => $this->description,
                // No need to update logo here as it's handled above
                // 'logo' => $file_name,
                // 'country_id' => $this->country_id,
                // 'state_id' => $this->state_id,
                // 'city_id' => $this->city_id,
            ]);

            DB::commit();

            $this->alert('success', __('Client updated successfully!'));
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            $this->alert('error', __('Something went wrong while updating the client.'));
        }
    }
    public function update_logo(): void
    {
        $this->validate([
            'logo' => 'required|image|max:2048', // Optional for update
        ]);
        // Handle logo upload if exists
        if ($this->logo) {
            $file_name = $this->logo->store('logo', 'public');
            $this->client->update(['logo' => $file_name]);
            if (File::where('client_id', $this->client->id)->where('type', 'business_logo')->first()) {
                File::where('client_id', $this->client->id)->where('type', 'business_logo')->first()->update(['path' => $file_name]);
                $this->alert('success', __('Client updated successfully!'));
            } else {
                File::create([
                    'label' => $file_name,
                    'path' => $file_name,
                    'visibility' => 'protected',
                    'mimes' => $this->logo->getMimeType(),
                    'type' => 'business_logo',
                    'info' => json_encode([
                        'size' => $this->logo->getSize(),
                        'original_name' => $this->logo->getClientOriginalName(),
                        'mimes' => $this->logo->getMimeType(),
                        'type' => $this->logo->getClientOriginalExtension(),
                    ]),
                    'user_id' => Auth::id(),
                    'client_id' => $this->client->id,
                ]);
                $this->alert('success', __('Client updated successfully!'));
            }
        }
    }
    public function cancel()
    {
        $this->reset();
        return redirect()->route('app');
    }
}
