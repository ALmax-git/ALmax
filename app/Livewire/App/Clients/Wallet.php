<?php

namespace App\Livewire\App\Clients;

use App\Models\Wallet as ModelsWallet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Numeric;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Wallet extends Component
{
    use LivewireAlert;
    public $transfer_modal = false;
    public ?ModelsWallet $wallet;
    public String $wallet_address;
    public $amount;

    public function init_account()
    {
        if (ModelsWallet::where('address', $this->wallet_address)->first()) {
            $this->wallet = ModelsWallet::where('address', $this->wallet_address)->first();
        }
    }
    public function send(): void
    {
        if ($this->wallet && $this->amount > 0) {
            $wallet = ModelsWallet::find(Auth::user()->wallet->id);
            $wallet->balance = Auth::user()->wallet->balance - $this->amount;
            $wallet->save();
            Auth::user()->wallet->balance =  $wallet->balanc;
            $this->wallet->balance = $this->wallet->balance + $this->amount;
            $this->wallet->save();
            $this->close_transfer_modal();
            $this->render();
        }
    }
    public function open_transfer_modal()
    {
        $this->transfer_modal = true;
    }
    public function mount($client = false)
    {
        if ($client) {
            $this->wallet = Auth::user()->client->wallet;
        } else {
            $this->wallet = Auth::user()->wallet;
        }
    }
    public function close_transfer_modal()
    {
        $this->transfer_modal = false;
        // $this->reset();
    }

    public function render()
    {
        return view('livewire.app.clients.wallet');
    }
}
