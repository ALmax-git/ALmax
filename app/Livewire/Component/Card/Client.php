<?php

namespace App\Livewire\Component\Card;

use Livewire\Component;

class Client extends Component
{
    public $client;
    public function mount($client)
    {
        $this->client = $client;
    }
    public function render()
    {
        return view('livewire.component.card.client');
    }
}
