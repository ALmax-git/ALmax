<?php

namespace App\Livewire\App;

use Livewire\Component;

class Error404 extends Component
{
    public $text;
    public function mount($text = 'Not Found  🫤')
    {
        $this->text = $text;
    }
    public function render()
    {
        return view('livewire.app.error404');
    }
}
