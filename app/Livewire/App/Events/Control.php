<?php

namespace App\Livewire\App\Events;

use App\Models\Event;
use Livewire\Component;

class Control extends Component
{
    public $events = [];
    public $event;
    public $ticket_modal = false;
    public $tx_ref, $id;

    public function buy_ticket($id): void
    {
        $this->event = Event::find(read($id));
        $this->ticket_modal = true;
        $this->tx_ref = generate_tx_ref();
        $this->id = write($this->event->id);
    }
    public function close_buy_ticket(): void
    {
        $this->ticket_modal = false;
    }
    public function mount()
    {
        $this->events = Event::orderBy('created_at', 'desc')->where('status', 'confirmed')->get();
    }
    public function render()
    {
        return view('livewire.app.events.control');
    }
}
