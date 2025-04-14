<?php

namespace App\Livewire\Auth;

use App\Models\Session;
use App\Models\User;
use Livewire\Component;

class Auth extends Component
{

    public $user_log = '';
    public $tab;
    public function mount($tab = null)
    {
        $this->tab = $tab ?? "Login";
    }
    public function toggle_tab($tab)
    {
        $this->tab = $tab;
    }

    public function check_seesioon($id)
    {
        if (Session::where('user_id', $id)->exists()) {
            if ($id > 1) {
                $this->user_log = "This User is already Log on Another Computer please Contact you Admin!";
            }
        }
    }
    public function render()
    {
        \App\helpers\RequestTracker::track();
        return view('livewire.auth.auth');
    }
}
