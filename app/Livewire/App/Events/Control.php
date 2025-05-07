<?php

namespace App\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Control extends Component
{
    public $events = [];
    public function mount()
    {
        $this->events = Event::orderBy('created_at', 'desc')->where('status', 'confirmed')->get();
    }
    public function render()
    {
        return view('livewire.app.events.control');
    }
}
