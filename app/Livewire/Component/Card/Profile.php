<?php

namespace App\Livewire\Component\Card;

use App\Models\User;
use Livewire\Component;

class Profile extends Component
{
    public $email, $profile;
    public function mount($email)
    {
        $this->profile = User::where('email', $email)->first();
        if (!$this->profile) {
            return;
        }
    }
    public function render()
    {
        return view('livewire.component.card.profile');
    }
}
