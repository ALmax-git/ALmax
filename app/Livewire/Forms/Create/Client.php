<?php

namespace App\Livewire\Forms\Create;

use App\Models\Client as ModelsClient;
use App\Models\ClientCategory;
use App\Models\Country;
use App\Models\File;
use App\Models\State;
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
    public $logo; // File upload
    public ?int $category_id = null, $country_id = null, $state_id = null, $city_id = null;

    // Dropdown Data
    public $business_categories = [];
    public $countries = [], $states = [], $cities = [];

    // Model References
    public $country, $state, $client;

    /**
     * Mount the component and preload data.
     */
    public function mount(): void
    {
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
    public function submit(): \Illuminate\Http\RedirectResponse
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
    public function cancel()
    {
        $this->reset();
        return redirect()->route('app');
    }
}
