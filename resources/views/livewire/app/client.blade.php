<div class="container-fluid px-4 pt-4">
  <div class="card bg-black" style="background-color: black;">
    <div class="row g-4 bg-black">
      <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
          <i class="fa bi-boxes fa-3x text-primary"></i>
          <div class="ms-3">
            <p class="mb-2">{{ _app('Products') }}</p>
            <h6 class="mb-0 text-right">{{ $client->products->count() }}</h6>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
          <i class="fa bi-boxes fa-3x text-success"></i>
          <div class="ms-3">
            <p class="mb-2">{{ _app('available_products') }}</p>
            <h6 class="mb-0 text-right">{{ $client->available_products->count() }}</h6>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
          <i class="fa bi-people fa-3x text-primary"></i>
          <div class="ms-3">
            <p class="mb-2">{{ _app('Users') }}</p>
            <h6 class="mb-0 text-right">{{ count($client->users) }}</h6>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
          <i class="fa bi-files fa-3x text-primary"></i>
          <div class="ms-3">
            <p class="mb-2">{{ _app('Files') }}</p>
            <h6 class="mb-0 text-right">{{ $client->files()->count() }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  @if ($view_business_card)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('business_card') }}</h5>
            <button class="close" type="button" wire:click="close_view_business_card">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <livewire:component.card.client :client="$client" loading="lazy" />
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_view_business_card">{{ _app('cancel') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="card bg-black">
    <div class="bg-secondary col-12 rounded p-3">
      @if ($client->status == 'setup')
        <span class="badge bg-info text-white">{{ _app('business_is_in_setup_mode') }}</span>
        <button class="btn btn-sm btn-warning" wire:click='init_client_activation'> {{ _app('activate_business') }}
        </button>
        @if ($confirm_activation)
          <div class="modal" tabindex="-1" style="display:block;">
            <div class="modal-dialog">
              <div class="modal-content bg-secondary">
                <div class="modal-header">
                  <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
                  <button class="close" type="button" wire:click="cancel_client_activation">
                    <span>&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>{{ _app('are_you_sure_you_want_to_activate_this_account') }}?</p>
                  <h3 class="text-primary text-center">{{ $client->name }} <strong>-</strong>
                    {{ $client->country->flag }}
                  </h3>
                  <p> {{ _app('NOTE:_once_activate_you_products_and_services_will_be_publish_live') }} </p>
                  <input class="form-control" type="password" wire:model.live="password"
                    placeholder="Enter your password to confirm">
                  @error($password)
                    <span>{{ $message }}</span>
                  @enderror
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button"
                    wire:click="cancel_client_activation">{{ _app('cancel') }}</button>
                  <button class="btn btn-success" type="button"
                    wire:click="activate_client_account">{{ _app('Activate') }}</button>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endif
      <button class="btn btn-sm btn-primary" wire:click='open_view_business_card'>{{ _app('View') }}</button>
      {{-- <button class="btn btn-sm btn-success"><i class="bi bi-security"></i> {{ _app('start_K_Y_C') }}</button> --}}
    </div>
    <div class="bg-secondary col-12 rounded p-3">
      <livewire:forms.create.client :client="$client" loading="lazy" />
    </div>
  </div>
</div>
