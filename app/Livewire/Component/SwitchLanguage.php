<?php

namespace App\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SwitchLanguage extends Component
{


    public function swich_language($language)
    {
        // Update the user's language preference
        Auth::user()->update(['language' => $language]);
        return redirect()->route('app');
    }

    public function render()
    {
        return view('livewire.component.switch-language');
    }
}
