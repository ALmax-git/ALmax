<div class="container-fluid">

  <div class="bg-secondary mb-4 rounded bg-black p-2">
    <div class="d-flex" style="background-color: black;">
      <input class="form-control me-2" type="text" wire:model.live="search" placeholder=" 🔍 {{ _app('search') }}">
      <button class="btn btn-sm btn-success float-end" wire:click='open_new_asset'>+</button>
    </div>
  </div>
  <div class="bg-black p-2" style="background-color: black;">
    <div class="row g-4 bg-black">
      <style>
        .asset:hover {
          transform: scale(1.01);
        }
      </style>
      @foreach ($assets as $Asset)
        <div class="col-sm-6 col-xl-3 asset" style="cursor: pointer;"
          wire:click='edit_asset("{{ write($Asset->id) }}")'>
          <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
            <i class="fa bi-boxes fa-3x text-{{ $Asset->is_verified ? 'success' : 'danger' }}"></i>
            <div class="ms-3">
              <p class="mb-2">{{ _app($Asset->label) }}</p>
              <h6 class="mb-0 text-right">{{ $Asset->value }}</h6>
            </div>
          </div>
        </div>
      @endforeach

    </div>
  </div>
  @if ($asset_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('create_product') }}</h5>
            <button class="close" type="button" wire:click="close_asset_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body scrollable scroll">

            {{--   $this->reset(['is_edit', 'asset', 'label', 'symbol', 'type', 'is_verified', 'value']); --}}
            <label class="form-label" for="label">{{ _app('label') }}</label>
            <input class="form-control" type="text" wire:model.live="label" placeholder="{{ _app('label') }}">
            @error('label')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <label class="form-label" for="sign">{{ _app('sign') }}</label>
            <input class="form-control" type="text" wire:model.live="sign" placeholder="{{ _app('sign') }}">
            @error('sign')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <label class="form-label" for="type">{{ _app('type') }}</label>
            <select class="form-control" id="type" name="type" wire:model.live='type'>
              <option value="">{{ _app('choose') }}</option>
              <option value="crypto">{{ _app('crypto') }}</option>
              <option value="currency">{{ _app('currency') }}</option>
              <option value="fiat">{{ _app('fiat') }}</option>
              <option value="NFTs">{{ _app('NFTs') }}</option>
              <option value="stock">{{ _app('stock') }}</option>
              <option value="others">{{ _app('others') }}</option>
            </select>
            @error('type')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <label class="form-label" for="symbol">{{ _app('symbol') }} {{ $symbol }} </label>
            <textarea class="form-control" type="text" wire:model.live="symbol" placeholder="{{ _app('symbol') }}"></textarea>
            @error($symbol)
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <label class="form-label" for="value">{{ _app('value') }}</label>
            <input class="form-control" type="number" wire:model.live="value" placeholder="{{ _app('value') }}">
            @error('value')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <input class="form-check-input bg-danger" id="is_verifiedToggle" type="checkbox"
              value="{{ $is_verified }}" {{ $is_verified ? 'checked' : '' }} wire:model.live="is_verified">
            <label class="form-check-label" for="is_verifiedToggle">{{ _app('is_verified') }}</label>
            @error('is_verified')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_asset_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-primary" type="button" wire:click="save_asset">{{ _app('save') }}</button>

          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($comfirm_action_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
            <button class="close" type="button" wire:click="close_asset_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('enter_your_password_to_comfirm_action') }}?</p>
            <h3 class="text-primary text-center">{{ $asset->label }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_asset_modal">{{ _app('cancel') }}</button>

            <button class="btn btn-danger" type="button"
              wire:click="cormfirm_action">{{ _app('comfirm') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
