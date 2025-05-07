<?php

namespace App\Livewire\App\Client;

use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class People extends Component
{
    public $profile_modal = false, $profile;

    public function view_profile($id): void
    {
        $this->profile = User::find(read($id));
        $this->profile_modal = true;
    }
    public function close_profile(): void
    {
        $this->profile = null;
        $this->profile_modal = false;
    }
    // public $follower = 'follow';
    public function toggle_follow($id)
    {
        $followship = Follower::where('user_id', Auth::user()->id)->where('target_id', read($id))->first();
        if ($followship) {
            $followship->delete();
            // $this->follower = 'follow';
        } else {
            Follower::create([
                'user_id' => Auth::user()->id,
                'target_id' => read($id)
            ]);
            // $this->follower = 'Following';
        }
    }
    public $people = [];
    public function mount()
    {
        $this->people = User::where('visibility', 'public')->orderBy('created_at', 'desc')->get();
    }
    public function render()
    {
        return view('livewire.app.client.people');
    }
}
