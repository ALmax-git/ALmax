<?php

namespace App\Livewire\App\Clients;

use App\Models\Asset;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Assets extends Component
{
    use LivewireAlert;
    public $search = '';
    public $asset_modal = false;
    public $comfirm_action_modal = false;
    public $asset, $label, $symbol, $type, $is_verified, $value, $action, $password;
    public function open_new_asset()
    {
        $this->asset =  new Asset();
        $this->label = '';
        $this->symbol = '';
        $this->type = null;
        $this->is_verified = false;
        $this->value = 0;
        $this->action = 'create';
        $this->password = '';
        $this->comfirm_action_modal = false;
        $this->asset_modal = true;
    }
    public function close_asset_modal()
    {
        $this->reset(['action', 'asset', 'label', 'symbol', 'type', 'is_verified', 'value', 'password']);
        $this->asset_modal = false;
        $this->comfirm_action_modal = false;
    }
    public function save_asset()
    {
        $this->asset->label = $this->label;
        $this->asset->symbol = $this->symbol;
        $this->asset->type = $this->type;
        $this->asset->is_verified = $this->is_verified;
        dd($this->asset);
        $this->asset->value = $this->value;

        $this->asset_modal = false;
        $this->comfirm_action_modal = true;
    }
    public function edit_asset($id)
    {
        $this->asset = Asset::find(read($id));
        $this->label = $this->asset->label;
        $this->symbol = $this->asset->symbol;
        $this->type = $this->asset->type;
        $this->value = $this->asset->value;
        $this->is_verified = $this->asset->is_verified;
        $this->comfirm_action_modal = false;
        $this->action = 'update';
        $this->asset_modal = true;
    }
    public function cormfirm_action()
    {
        $this->validate([
            'password' => 'required|string|min:6',
        ]);

        if (Hash::check($this->password, auth()->user()->password)) {
            switch ($this->action) {
                case 'delete':
                    $this->asset->delete();
                    break;
                case 'update':
                    $this->asset->save();
                    $this->alert('success', 'Asset saved successfully!');
                    break;
                default:
                    $this->asset->save();
                    $this->alert('success', 'Asset saved successfully!');
                    break;
            }
            $this->close_asset_modal();
        } else {
            $this->alert('error', 'Incorrect password.');
            return;
        }
    }
    public function render()
    {
        $assets = Asset::orderBy('value')
            ->where('label', 'like', "%{$this->search}%")
            ->get();
        return view('livewire.app.clients.assets', compact('assets'));
    }
}
