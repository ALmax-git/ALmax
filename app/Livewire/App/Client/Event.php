<?php

namespace App\Livewire\App\Client;

use App\Models\Country;
use App\Models\Event as ModelsEvent;
use Livewire\Component;
use App\Models\State;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Event extends Component
{
    use LivewireAlert, WithPagination;
    public $search, $title, $location, $description, $type, $status, $start_time, $end_time, $price,
        $closing_day, $starting_day, $organizer_id, $password;
    public $event, $is_edit;
    public $add_event_modal = false, $event_delete_modal = false;

    public $category_id = null, $country_id = null, $state_id = null, $city_id = null;

    // Dropdown Data
    public $countries = [], $states = [], $cities = [];
    // Model References
    public $country, $state, $client;

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
    public function open_add_event_modal()
    {
        $this->add_event_modal = true;
    }
    public function close_add_event_modal()
    {
        $this->add_event_modal = false;
        $this->reset();
    }
    public function create_event(): void
    {
        $this->event = new ModelsEvent();
        $this->event->user_id = Auth::user()->id;
        $this->event->client_id = Auth::user()->client->id;
        $this->event->organizer_id = $this->organizer_id;
        $this->event->title = $this->title;
        $this->event->description = $this->description;
        $this->event->location = $this->location;
        $this->event->start_time = $this->start_time;
        $this->event->end_time = $this->end_time;
        $this->event->starting_day = $this->starting_day;
        $this->event->closing_day = $this->closing_day;
        $this->event->price = $this->price;
        $this->event->status = 'pending';
        $this->event->country_id = $this->country_id;
        $this->event->state_id = $this->state_id;
        $this->event->city_id = $this->city_id;
        $this->event->type = $this->type;
        $this->event->save();
        $this->alert('success', 'Event created successfully!');
        $this->close_add_event_modal();
    }
    public function edit_event($id)
    {
        $this->event = ModelsEvent::find($id);
        $this->title = $this->event->title;
        $this->location = $this->event->location;
        $this->description = $this->event->description;
        $this->type = $this->event->type;
        $this->status = $this->event->status;
        $this->start_time = $this->event->start_time;
        $this->end_time = $this->event->end_time;
        $this->price = $this->event->price;
        $this->closing_day = $this->event->closing_day;
        $this->starting_day = $this->event->starting_day;
        $this->organizer_id = $this->event->organizer_id;
        $this->category_id = $this->event->category_id;
        $this->country_id = $this->event->country_id;
        $this->state_id = $this->event->state_id;
        $this->city_id = $this->event->city_id;
        $this->add_event_modal = true;
        $this->is_edit = true;
    }
    public function update_event()
    {
        $this->event->title = $this->title;
        $this->event->description = $this->description;
        $this->event->location = $this->location;
        $this->event->start_time = $this->start_time;
        $this->event->end_time = $this->end_time;
        $this->event->starting_day = $this->starting_day;
        $this->event->closing_day = $this->closing_day;
        $this->event->price = $this->price;
        $this->event->country_id = $this->country_id;
        $this->event->state_id = $this->state_id;
        $this->event->city_id = $this->city_id;
        $this->event->type = $this->type;
        $this->event->save();
        $this->alert('success', 'Event updated successfully!');
        $this->close_add_event_modal();
    }
    public function confirm_event($id)
    {
        $event = ModelsEvent::find($id);
        $event->status = 'confirmed';
        $event->save();
        $this->alert('success', 'Event confirmed successfully!');
    }
    public function delete_event($id)
    {
        $this->event_delete_modal = true;
        $this->event = ModelsEvent::find($id);
    }
    public function confirm_delete_event()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        // Check if the entered password is correct
        if (Hash::check($this->password, auth()->user()->password)) {
            $this->event->status = 'cancelled';
            $this->event->save();
            $this->alert('success', 'Product variant deleted successfully!');
        } else {
            $this->alert('error', 'Incorrect password. Please try again.');
            return;
        }

        $this->close_delete_event_modal();
    }
    public function close_delete_event_modal()
    {
        $this->event_delete_modal = false;
    }
    public function mount()
    {

        if (request()->get('page', 1) > 1) {
            $this->resetPage();
        }
        $this->countries = Country::where('status', 'active')->orderBy('name')->get();
    }
    public function render()
    {
        $events = ModelsEvent::where('client_id', Auth::user()->client->id)
            ->where('status', '!=', 'cancelled')
            ->where('title', 'like', '%' . $this->search . '%')
            ->paginate(10);
        // dd($events, Auth::user()->client->events);
        return view('livewire.app.client.event', compact('events'));
    }
}
