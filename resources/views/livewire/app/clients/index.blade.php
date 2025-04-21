<div class="container py-4">
  <div class="row mb-4">
    <div class="col-md-4 mb-2">
      <input class="form-control bg-dark border-danger text-white" type="text" wire:model.live="search"
        placeholder="Search Clients...">
    </div>
    <div class="col-md-3 mb-2">
      <select class="form-control bg-dark border-danger text-white" wire:model.live="statusFilter">
        <option value="all">All Statuses</option>
        <option value="active">Active</option>
        <option value="suspended">Suspended</option>
        <option value="setup">Setup</option>
        <option value="closed">Closed</option>
        <option value="under_review">Under Review</option>
        <option value="terminated">Terminated</option>
      </select>
    </div>
    <div class="col-md-2 form-check form-switch text-white">
      <input class="form-check-input bg-danger" id="verifiedToggle" type="checkbox" wire:model.live="showVerified">
      <label class="form-check-label" for="verifiedToggle">Verified</label>
    </div>
    <div class="col-md-2 form-check form-switch text-white">
      <input class="form-check-input bg-danger" id="registeredToggle" type="checkbox" wire:model.live="showRegistered">
      <label class="form-check-label" for="registeredToggle">Registered</label>
    </div>
  </div>

  @if (session()->has('message'))
    <div class="alert alert-success bg-success text-white">
      {{ session('message') }}
    </div>
  @endif
  @if ($modal)
    @switch($modal)
      @case('delete')
        <div class="alert alert-danger border-danger bg-dark rounded border p-4 text-white shadow">
          <hr class="border-danger">
          <center><strong class="text-danger">Are you sure you want to delete this client?</strong></center>
          <hr class="border-danger">

          <h2 class="text-danger text-center"><u>{{ $client->name }}</u></h2>
          <p><strong>Owner:</strong> {{ $client->owner?->name ?? 'N/A' }}</p>
          <p><strong>Phone:</strong> {{ $client->telephone }}</p>
          <p><strong>Email:</strong> {{ $client->email }}</p>
          <p><strong>Tagline:</strong> {{ $client->tagline }}</p>
          <p><strong>Overview:</strong> {{ $client->overview }}</p>

          <div class="mb-3">
            <label class="form-label" for="deletePassword">Confirm Password</label>
            <input class="form-control bg-dark border-danger text-white" id="deletePassword" type="password"
              wire:model.live="password" placeholder="Enter your password">
            @error('password')
              <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="d-flex justify-content-between">
            <button class="btn btn-danger" wire:click="delete_client_comfirm">Yes, Delete</button>
            <button class="btn btn-secondary" wire:click="$set('modal', null)">Cancel</button>
          </div>
        </div>
      @break

      @default
    @endswitch
  @else
    <div class="row">
      @forelse ($clients as $client)
        <div class="col-md-4 mb-4">
          <div class="card bg-dark border-primary h-100 text-white shadow-sm" style="transition: transform .3s;"
            onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
            <div class="card-header d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <img class="rounded-circle me-2" src="{{ $client->logo() }}"
                  style="width: 50px; height: 50px; object-fit: cover;">
                <div>
                  <h5 class="mb-0">{{ $client->name }}</h5>
                  <small class="text-primary">{{ $client->tagline }}</small>
                </div>
              </div>
              <span
                class="badge {{ $client->status == 'active' ? 'bg-success' : 'bg-secondary' }}">{{ ucfirst($client->status) }}</span>
            </div>
            <div class="card-body">
              <p><strong>Owner:</strong> {{ $client->owner?->name ?? 'N/A' }}</p>
              <p><strong>Phone:</strong> {{ $client->telephone }}</p>
              <p><strong>Email:</strong> {{ $client->email }}</p>
              <p class="text-muted small">{{ \Str::limit($client->overview, 100) }}</p>
            </div>
            <div class="card-footer d-flex justify-content-between">
              <button class="btn btn-sm {{ $client->is_verified ? 'btn-success' : 'btn-outline-success' }}"
                wire:click="toggleVerify({{ $client->id }})">
                {{ $client->is_verified ? 'Verified' : 'Verify' }}
              </button>
              <button class="btn btn-sm {{ $client->is_registered ? 'btn-warning' : 'btn-outline-warning' }}"
                wire:click="toggleRegister({{ $client->id }})">
                {{ $client->is_registered ? 'Registered' : 'Register' }}
              </button>
              <button class="btn btn-sm btn-outline-danger" wire:click="deleteClient({{ $client->id }})"
                wire:comfirm="Are you sure?">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-primary text-center">
            No clients found.
          </div>
        </div>
      @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
      {{ $clients->links() }}
    </div>
  @endif
</div>
