<?php

namespace App\Livewire\App\Card;

use App\Models\Empowerment;
use App\Models\Follower;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Profile extends Component
{
    use LivewireAlert;
    public ?User $user;
    public ?Empowerment $white_paper;
    public $title, $white_paper_text, $white_paper_modal = false;
    public $follower = 'follow';
    public $password;
    public function toggle_follow()
    {
        $followship = Follower::where('user_id', Auth::user()->id)->where('target_id', $this->user->id)->first();
        if ($followship) {
            $followship->delete();
            $this->follower = 'follow';
        } else {
            Follower::create([
                'user_id' => Auth::user()->id,
                'target_id' => $this->user->id
            ]);
            $this->follower = 'Following';
        }
    }
    public function init_white_paper()
    {
        $this->white_paper = new Empowerment();
        $this->white_paper_modal = true;
    }
    public function cancel_white_paper(): void
    {
        $this->white_paper = null;
        $this->white_paper_modal = false;
    }
    public function sign_white_paper(): void
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        if (Hash::check($this->password, auth()->user()->password)) {
            if (!(Empowerment::where('client_id', Auth::user()->client->id)->where('target_id', $this->user->id)->first())) {
                $this->white_paper->user_id = Auth::user()->id;
                $this->white_paper->client_id = Auth::user()->client->id;
                $this->white_paper->target_id = $this->user->id;
                $this->white_paper->title = $this->title;
                $this->white_paper->white_paper = $this->white_paper_text;
                $this->white_paper->save();
                $this->alert('success', 'White Paper Submitted successfully');
            } else {
                $this->alert('info', 'White Paper Already Submitted by ' . Empowerment::where('client_id', Auth::user()->client->id)->where('target_id', $this->user->id)->first()->hr->name);
            }
        } else {
            $this->alert('error', 'Incorrect password.');
            return;
        }
        $this->white_paper_modal = false;
    }
    public function mount($id): void
    {
        $this->user = User::find(read($id));
        if (Follower::where('user_id', Auth::user()->id)->where('target_id', $this->user->id)->first()) {
            $this->follower = 'Following';
        }
    }
    public function render()
    {
        return view('livewire.app.card.profile');
    }
}
