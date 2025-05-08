<?php

namespace App\Livewire\Component\Card;

use Livewire\Component;

class Eventticket extends Component
{
    use \Jantinnerezo\LivewireAlert\LivewireAlert;
    public $id;
    public $event_ticket;
    public $qr_code;
    public function mount($id)
    {
        $this->id = $id;
        $this->event_ticket = \App\Models\EventTicket::find($id);
        if (!$this->event_ticket) {
            $this->alert('error', 'Event ticket not found');
            return;
        }
        $this->qr_code = generate_qr_code($this->event_ticket->qr_key);
    }
    public function render()
    {
        return view('livewire.component.card.eventticket');
    }
}
