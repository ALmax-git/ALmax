<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pos extends Component
{
    public $profile_view = false;

    public function open_profile_view(): void
    {
        $this->profile_view = true;
    }
    public function close_profile_view(): void
    {
        $this->profile_view = false;
    }
    /**
     * Logs the user out and redirects to login page.
     */
    public function logout()
    {
        Auth::logout(); // Safely log out current user
        return redirect()->route('login'); // Redirect to login route
    }

    public function render()
    {
        $sales = Auth::user()->client->sales()
            ->with(['user', 'client', 'product'])
            ->latest()
            ->paginate(10);
        return view('livewire.pos', [
            'sales' => $sales,
        ]);
    }
}
