<?php

namespace App\Livewire\App;

use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Control extends Component
{
    use LivewireAlert;

    public $tab = 'Clients';



    // Method to toggle tab
    public function toggle_c_tab($tab)
    {
        $this->tab = $tab;
    }

    // Mount method to initialize tab
    public function mount()
    {
        $this->tab = 'Geolocation'; // Initial tab
        $this->toggle_c_tab('Clients'); // Toggle to the Clients tab
    }
    public function render()
    {
        return view('livewire.app.control');
    }
}
