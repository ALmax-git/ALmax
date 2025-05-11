<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Gate extends Component
{
    use LivewireAlert;
    public $email = '';

    public function open_gate()
    {

        if ($this->email != '') {
            try {
                $user = User::where('email', $this->email)->first();
                if ($user) {
                    $name = $user->name ?? 'User!';
                    $this->alert('success', 'Welcome Back ' . $name);
                    session(['email' => $this->email, 'username' => $name]);
                    return redirect()->route('login');
                } else {
                    $this->alert('info', 'Hello World! Nice to have you onboard.');
                    session(['email' => $this->email]);
                    return redirect()->route('register');
                }
            } catch (\Throwable $th) {
                $this->alert('error', 'Oops! 😖  Unknown Error Occurred, Please Contact Support.');
            }
        } else {
            $this->alert('error', "Oops! 😖 An invalid email address.");
        }
    }
    public function mount()
    {

        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->route('app');
        }
    }
    public function render()
    {
        return view('livewire.gate');
    }
}
