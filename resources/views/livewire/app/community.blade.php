<div class="container-fluid px-4 pt-4">
  <div class="bg-secondary rounded-top mb-2 mt-2 p-3">
    @if ($profile_modal)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-center">
          <div class="modal-content bg-secondary">
            <div class="modal-header">
              <button class="close btn btn-secondary" type="button" wire:click="close_profile">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              @livewire('app.card.profile', ['id' => write($profile->id)])
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button" wire:click="close_profile">{{ _app('close') }}</button>
            </div>
          </div>
        </div>
      </div>
    @endif
    <h2 class="text-primary mb-4">🌐 Community Members</h2>
    <div class="row g-3 mb-3">
      <div class="col-md-4">
        <input class="form-control bg-dark border-primary text-white" type="text"
          wire:model.live.debounce.300ms="search" placeholder="🔍 Search by name">
      </div>
      <div class="col-md-2">
        <select class="bg-dark border-primary form-select text-white" wire:model.live="country_id">
          <option value="">🌍 Country</option>
          @foreach ($countries as $Country)
            <option value="{{ $Country->id }}" wire:click='change_country("{{ write($Country->id) }}")'>
              {{ $Country->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select class="bg-dark border-primary form-select text-white" wire:model.live="state_id">
          <option value="">🗺 State</option>
          @foreach ($states as $State)
            <option value="{{ $State->id }}" wire:click='change_state("{{ write($State->id) }}")'>
              {{ $State->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select class="bg-dark border-primary form-select text-white" wire:model.live="city_id">
          <option value="">🏙 City</option>
          @foreach ($cities as $city)
            <option value="{{ $city->id }}">{{ $city->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <select class="bg-dark border-primary form-select text-white" wire:model.live="client_id">
          <option value="">💼 Client</option>
          @foreach ($clients as $client)
            <option value="{{ $client->id }}">{{ $client->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <hr>
  <div class="bg-secondary rounded-top mb-2 mt-2 p-3">
    @if ($people->count())
      <div class="row g-4">
        @forelse ($people as $user)
          <div class="col-md-3">
            <div class="card bg-dark border-primary h-100 text-white shadow-lg">
              <img class="card-img-top border-bottom border-primary" src="{{ $user->profile_photo_url }}"
                alt="Profile photo">
              <div class="card-body">
                <h5 class="card-title text-info">{{ $user->name }}</h5>
                <p class="card-text small">{!! Str::limit($user->bio ?? 'No bio available.', 80) !!}</p>
              </div>
              <div class="card-footer text-muted small">
                <i class="bi bi-people"></i> {{ $user->followers->count() }}<br>
                📧 {{ $user->visibility == 'public' ? $user->email : '***@**.*' }}<br>
                🌍 {{ optional($user->client)->name ?? 'No client' }}
                <button class="btn btn-sm btn-outline-success float-end"
                  wire:click='view_profile("{{ write($user->id) }}")'>
                  <i class="bi bi-eye"></i>
                </button>
              </div>
            </div>
          </div>
        @empty
          @livewire('app.error404', ['text' => 'Ops No result found Try Search'])
        @endforelse
      </div>

      <div class="mt-4">
        {{ $people->links('pagination::bootstrap-5') }}
      </div>
    @else
      @livewire('app.error404', ['text' => 'No users found 🫤'])
    @endif
  </div>
</div>
