<div>
  <style>
    .asset-card:hover {
      transform: scale(1.02);
    }
  </style>
  <div class="progress-appp-2 min-h-75">
    <main class="progress-container w-100 p-4">
      <div class="progress-panel p-4">
        <div class="panel-header">
          <div class="system-status">
            <span class="status-indicator"></span>
            <span class="status-text">{{ $wallet->label }}</span>
          </div>
        </div>
        {{-- <div class="panel-header">
          <span class="status-text">{{ $wallet->label }}</span>
        </div> <!--₦--> --}}
        <div class="progress-section">
          <div class="progress-wrapper">
            <div class="progress-bar" role="progressbar" aria-valuemax="100" aria-valuemin="0"
              aria-valuenow="{{ (float) $wallet->balance / 100 }}">
              <div class="progress-line"></div>
              <div class="progress-particles text-shadow-dark text-white">
                <span class="fa-2x">
                  <button class="rounded-circle tn btn-lg rounded-pill btn-dark text-white"
                    style="cursor: -moz-grabbing;"><i class="bi bi-dot"></i></button>
                  {{ $wallet->balance }}
                </span>
              </div>
            </div>
          </div>

          <div class="align-center justify-center text-center">
            {{-- <div class="col-lg-6"> --}}
            <button class="btn btn-lg rounded-pill btn-outline-info m-2" type="button"
              wire:click='open_transfer_modal'>
              <i class="bi bi-telegram"></i>
            </button>
            <button class="btn btn-lg rounded-pill btn-outline-primary m-2" type="button">
              <i class="bi bi-arrow-down"></i>
            </button>
            {{-- </div>
            <div class="col-lg-6"> --}}
            <button class="btn btn-lg rounded-pill btn-outline-info m-2" type="button">
              <i class="bi bi-gear"></i>
            </button>
            <button class="btn btn-lg rounded-pill btn-outline-light m-2" type="button" wire:click='refresh'>
              <i class="fa fa-refresh"></i>
            </button>
            <button class="btn btn-lg rounded-pill btn-outline-success m-2" type="button"
              wire:click='open_funding_modal'>
              <i class="bi bi-plus"></i>
            </button>
            <button class="btn btn-lg rounded-pill btn-outline-white m-2" type="button">
              <i class="bi bi-qr-code"></i>
            </button>
            {{-- </div> --}}
          </div>
          <div class="h-100 scrollable p-2">
            <ul class="m-0 p-0">
              @foreach ($wallet->assets as $asset)
                <li class="d-flex asset-card mb-4 rounded p-2"
                  style="border-inline: 2px solid rgb(0, 0, 107);
                background-color: rgba(151, 153, 162, 0.246);
                border-block: 1px solid gray;
                ">
                  <div class="avatar fw-bold me-3 flex-shrink-0">
                    {!! $asset->origin->symbol !!}
                  </div>
                  <div class="d-flex w-100 align-items-center justify-content-between flex-wrap gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">{{ $asset->origin->label }}</h6>
                      <small class="text-muted"> ~ {{ $asset->origin->value }}</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold">{{ $asset->amount }}</small>
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
          <div class="h-100 scrollable p-2">
            <ul class="m-0 p-0">
              @foreach ($wallet->transactions as $transaction)
                <li class="d-flex asset-card mb-4 rounded p-2" style="border: 1px solid blue;">
                  <div class="avatar me-3 flex-shrink-0">
                    @if ($transaction->type == 'credit')
                      <span class="avatar-initial bg-label-primary rounded">CR</span>
                    @else
                      <span class="avatar-initial bg-label-danger rounded">DB</span>
                    @endif
                  </div>
                  <div class="d-flex w-100 align-items-center justify-content-between flex-wrap gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">{{ $transaction->sender->name }}</h6>
                      <small class="text-muted">{{ $transaction->description }}</small>
                    </div>
                    <div class="user-progress">
                      <small class="fw-semibold">{{ $transaction->amount }}</small>
                    </div>
                  </div>
                </li>
              @endforeach

            </ul>
          </div>
        </div>
      </div>
    </main>
  </div>
  @if ($transfer_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ Auth::user()->wallet->label }}</h5>
            <button class="close" type="button" wire:click="close_transfer_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @if ($wallet)
              <h3 class="text-primary text-center">{{ $wallet->label }}</h3>
            @endif
            <label for="wallet_address">{{ _app('wallet_address') }}</label>
            <input class="form-control" type="text" wire:change='init_account' wire:model.live="wallet_address"
              placeholder="wallet address">
            @error($wallet_address)
              <span>{{ $message }}</span>
            @enderror
            <label for="amount">{{ _app('amount') }}</label>
            <input class="form-control" type="text" wire:model.live="amount" placeholder="Amount">
            @error($amount)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_transfer_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="send">{{ _app('Send') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($funding_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content bg-secondary" method="POST" action="{{ route('fund_wallet') }}">
          <div class="modal-header">
            <h5 class="modal-title">{{ Auth::user()->wallet->label }}</h5>
            <button class="close" type="button" wire:click="close_funding_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @csrf
            @if ($wallet)
              <h3 class="text-primary text-center">{{ $wallet->label }}</h3>
            @endif
            <label for="amount">{{ _app('amount') }}</label>
            <input class="form-control" name="amount" type="text" wire:model.live="amount"
              placeholder="Amount">
            @error($amount)
              <span>{{ $message }}</span>
            @enderror
            <input name="wallet_id" type="hidden" value="{{ write($wallet->id) }}">
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_funding_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="submit">{{ _app('Fund') }}</button>
          </div>
        </form>
      </div>
    </div>
  @endif
</div>
