<div>
  <!-- Search Box -->
  <div class="d-flex mb-4">
    <input class="form-control me-2" type="text" wire:model.live="searchTerm" placeholder="{{ _app('geo_search') }}">

    <!-- Countries Dropdown -->
    <select class="form-control me-2" wire:model.live="selectedCountry">
      <option value="">{{ _app('select_country') }}</option>
      @foreach ($countries as $country)
        <option value="{{ $country->id }}">{{ $country->name }} ({{ $country->code }})</option>
      @endforeach
    </select>

    <!-- States Dropdown -->
    <select class="form-control me-2" wire:model.live="selectedState">
      <option value="">{{ _app('select_state') }}</option>
      @foreach ($states as $state)
        <option value="{{ $state->id }}">{{ $state->name }}</option>
      @endforeach
    </select>
  </div>

  <div class="d-flex mb-4" style="justify-content: space-between;">
    <div class="div">
      <button class="btn btn-sm btn-{{ $tab == 'City' ? 'primary' : 'secondary' }}"
        wire:click="switchTab('City')">{{ _app('City') }}</button>
      <button class="btn btn-sm btn-{{ $tab == 'State' ? 'primary' : 'secondary' }}"
        wire:click="switchTab('State')">{{ _app('State') }}</button>
      <button class="btn btn-sm btn-{{ $tab == 'Country' ? 'primary' : 'secondary' }}"
        wire:click="switchTab('Country')">{{ _app('Country') }}</button>
    </div>

    <div class="div">
      {{-- <!-- Add City Button --> --}}
      <button class="btn btn-sm btn-primary" wire:click="addCityModal">+ {{ _app('City') }}</button>
      {{-- Add State --}}
      <button class="btn btn-sm btn-primary" wire:click="add_state_modal">+ {{ _app('State') }}</button>
      {{-- Add Country --}}
      <button class="btn btn-sm btn-primary" wire:click="add_country_modal">+ {{ _app('Country') }}</button>
    </div>
  </div>

  @switch($tab)
    @case('City')
      <table class="mt-4 table">
        <thead>
          <tr>
            <th>{{ _app('City') }}</th>
            <th>{{ _app('postal_code') }}</th>
            <th>{{ _app('status') }}</th>
            <th>{{ _app('State') }}</th>
            <th>{{ _app('country') }}</th>
            <th>{{ _app('action') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($cities as $City)
            <tr>
              <td>{{ $City->name }}</td>
              <td>{{ $City->postal_code }}</td>
              <td>{{ $City->status }}</td>
              <td>{{ $City->state->name }}</td>
              <td>{{ $City->state->country->name }}</td>
              <td>
                @php
                  $id = $City->id;
                @endphp
                <button class="btn btn-danger"
                  wire:click='deleteCity("{{ write($id) }}")'>{{ _app('Delete') }}</button>
                <button class="btn btn-info" wire:click='edit_city("{{ write($id) }}")'>{{ _app('update') }}</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @break

    @case('State')
      <table class="mt-4 table">
        <thead>
          <tr>
            <th>{{ _app('State') }}</th>
            <th>{{ _app('City') }}</th>
            <th>{{ _app('status') }}</th>
            <th>{{ _app('country') }}</th>
            <th>{{ _app('action') }}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($states as $State)
            <tr>
              <td>{{ $State->name }}</td>
              <td>{{ $State->cities->count() }}</td>
              <td>{{ $State->status }}</td>
              <td>{{ $State->country->name }}</td>
              <td>
                <button class="btn btn-info"
                  wire:click='edit_state("{{ write($State->id) }}")'>{{ _app('update') }}</button>
                <button class="btn btn-danger"
                  wire:click='delete_state("{{ write($State->id) }}")'>{{ _app('Delete') }}</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @break

    @case('Country')
      <table class="mt-4 table">
        <thead>
          <tr>
            <th>{{ _app('country') }}</th>
            <th>{{ _app('Flag') }}</th>
            <th>Code</th>
            <th>ISO2</th>
            <th>ISO3</th>
            <th>Currency</th>
            <th>{{ _app('status') }}</th>
            <th>{{ _app('State') }}</th>
            <th>{{ _app('action') }}</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($countries as $Country)
            <tr>
              <td>{{ $Country->name }}</td>
              <td>{{ $Country->flag }}</td>
              <td>{{ $Country->code }}</td>
              <td>{{ $Country->iso2 }}</td>
              <td>{{ $Country->iso3 }}</td>
              <td>{{ $Country->currency }}</td>
              <td>
                <span class="badge {{ $Country->status ? 'bg-success' : 'bg-danger' }}">
                  {{ $Country->status ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td>{{ $Country->states->count() }}</td>
              <td>
                <button class="btn btn-info btn-sm"
                  wire:click='edit_country("{{ write($Country->id) }}")'>{{ _app('update') }}</button>
                <button class="btn btn-danger btn-sm"
                  wire:click='delete_country("{{ write($Country->id) }}")'>{{ _app('delete') }}</button>
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-center" colspan="8">No countries found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    @break

    @default
  @endswitch

  <!-- Pagination -->
  <div class="mt-4">
    {{ $cities->links() }}
  </div>

  <!-- Delete Confirmation Modal -->
  @if ($modalOpen)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button class="close" type="button" wire:click="$set('modalOpen', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $city->name }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('modalOpen', false)">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="confirmDelete">{{ _app('delete') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  <!-- Delete Confirmation Modal -->
  @if ($state_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button class="close" type="button" wire:click="$set('state_delete_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $state->name }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('state_delete_modal', false)">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button"
              wire:click="confirm_delete_state">{{ _app('delete') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  {{-- Country Delete Modal --}}
  @if ($country_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">Confirm Deletion</h5>
            <button class="close" type="button" wire:click="$set('country_delete_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $country->name }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error('password')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('country_delete_modal', false)">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button"
              wire:click="confirm_delete_country">{{ _app('delete') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Country Add/Edit Modal --}}
  @if ($country_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ $isEditing ? _app('update') : _app('add') }}</h5>
            <button class="close" type="button" wire:click="$set('country_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <input class="form-control mb-2" type="text" wire:model.live="country_name"
              placeholder="Country Name">
            @error('country_name')
              <span class="text-danger">{{ $message }}</span>
            @enderror

            <input class="form-control mb-2" type="text" wire:model.live="code" placeholder="Country Code">
            @error('code')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <input class="form-control mb-2" type="text" wire:model.live="flag" placeholder="Country flag">
            @error('flag')
              <span class="text-danger">{{ $message }}</span>
            @enderror

            <input class="form-control mb-2" type="text" wire:model.live="iso2" placeholder="ISO2">
            @error('iso2')
              <span class="text-danger">{{ $message }}</span>
            @enderror

            <input class="form-control mb-2" type="text" wire:model.live="iso3" placeholder="ISO3">
            @error('iso3')
              <span class="text-danger">{{ $message }}</span>
            @enderror

            <input class="form-control mb-2" type="text" wire:model.live="currency" placeholder="Currency">
            @error('currency')
              <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="col-md-2 form-check form-switch text-white">
              <input class="form-check-input bg-danger" id="CountryActiveToggle" type="checkbox"
                wire:model.live="statusToggle">
              <label class="form-check-label" for="CountryActiveToggle">{{ _app('Active') }}</label>
            </div>
            @error('statusToggle')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('country_modal', false)">{{ _app('Cancel') }}</button>
            @if ($isEditing)
              <button class="btn btn-primary mt-2" wire:click="update_country"><i class="bi bi-pen"></i>
                {{ _app('Country') }}</button>
            @else
              <button class="btn btn-success mt-2" wire:click="add_country">+ {{ _app('Country') }}</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- City Form for Add/Edit -->
  @if ($city_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ $isEditing ? _app('upadte') : _app('add') }}</h5>
            <button class="close" type="button" wire:click="$set('city_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <input class="form-control" type="text" wire:model.live="cityName" placeholder="City Name">
            @error($cityName)
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <input class="form-control mt-2" type="text" wire:model.live="postalCode" placeholder="Postal Code">
            @error($postalCode)
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <div class="col-md-2 form-check form-switch text-white">
              <input class="form-check-input bg-danger" id="ActiveToggle" type="checkbox"
                wire:model.live="statusToggle">
              <label class="form-check-label" for="ActiveToggle">{{ _app('Active') }}</label>
            </div>
            @error($statusToggle)
              <span class="text-danger">{{ $message }}</span>
            @enderror
            {{-- @if (!$isEditing) --}}
            <!-- Countries Dropdown -->
            <select class="form-control mb-2" wire:model.live="selectedCountry">
              <option value="">{{ _app('select_country') }}</option>
              @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }} ({{ $country->code }})</option>
              @endforeach
            </select>
            @error('selectedCountry')
              <span class="text-danger">{{ $message }}</span>
            @enderror

            <!-- States Dropdown -->
            <select class="form-control mb-2" wire:model.live="selectedState">
              <option value="">{{ _app('select_state') }}</option>
              @foreach ($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
              @endforeach
            </select>
            @error('selectedState')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            {{-- @endif --}}
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" wire:click="$set('city_modal', false)">Cancel</button>
            @if ($isEditing)
              <button class="btn btn-primary mt-2" wire:click="updateCity">Update City</button>
            @else
              <button class="btn btn-success mt-2" wire:click="addCity">Add City</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif

  @if ($state_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ $isEditing ? _app('upadte') : _app('add') }}</h5>
            <button class="close" type="button" wire:click="$set('state_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <input class="form-control" type="text" wire:model.live="state_name" placeholder="State Name">
            @error($state_name)
              <span class="text-danger">{{ $message }}</span>
            @enderror

            <div class="col-md-2 form-check form-switch text-white">
              <input class="form-check-input bg-danger" id="ActiveToggle" type="checkbox"
                wire:model.live="statusToggle">
              <label class="form-check-label" for="ActiveToggle">Active</label>
            </div>
            @error($statusToggle)
              <span class="text-danger">{{ $message }}</span>
            @enderror
            {{-- @if (!$isEditing) --}}
            <!-- Countries Dropdown -->
            <select class="form-control mb-2" wire:model.live="selectedCountry">
              <option value="">{{ _app('select_country') }}</option>
              @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }} ({{ $country->code }})</option>
              @endforeach
            </select>
            @error('selectedCountry')
              <span class="text-danger">{{ $message }}</span>
            @enderror

          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" wire:click="$set('state_modal', false)">
              {{ _app('cancel') }}</button>
            @if ($isEditing)
              <button class="btn btn-primary mt-2" wire:click="update_state"><i class="bi bi-pen"></i>
                {{ _app('City') }}</button>
            @else
              <button class="btn btn-success mt-2" wire:click="add_state">+ {{ _app('City') }}</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
  <script>
    Livewire.on('alert', function(data) {
      Swal.fire({
        icon: data.type,
        title: data.message,
        showConfirmButton: true
      });
    });
  </script>
</div>
