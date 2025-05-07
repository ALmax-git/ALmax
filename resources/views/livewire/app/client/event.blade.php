<div class="container-fluid pt-4" style="min-height: 80vh;">

  <div class="h-100 bg-secondary rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h6 class="mb-0">{{ _app('manage_events') }}</h6>
      {{-- <a href="#">Show All</a> --}}
    </div>

    <div class="d-flex mb-2">
      <input class="form-control me-2 bg-transparent" type="text" wire:model.live="search"
        placeholder=" 🔍 {{ _app('search_event') }}">
      <select class="form-select me-2 bg-transparent" wire:model.live="type">
        <option value="">{{ _app('all') }}</option>
        <option value="online">{{ _app('online') }}</option>
        <option value="offline">{{ _app('offline') }}</option>
      </select>
      <button class="btn btn-primary" wire:click="open_add_event_modal">{{ _app('Add') }}</button>
    </div>
    @if ($add_event_modal)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog modal-dialog-scrollable">
          <div class="modal-content bg-secondary">
            <div class="modal-header">
              <h5 class="modal-title">{{ _app('create_product') }}</h5>
              <button class="close" type="button" wire:click="close_add_event_modal">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body scrollable scroll">
              <div class="mb-3">
                <label for="title">{{ _app('title') }}</label>
                <input class="form-control bg-transparent" type="text" wire:model="title"
                  placeholder="{{ _app('title') }}">
                <label for="location">{{ _app('location') }}</label>
                <input class="form-control bg-transparent" type="text" wire:model="location"
                  placeholder="{{ _app('location') }}">
                <label for="price">{{ _app('price') }}</label>
                <input class="form-control bg-transparent" type="text" wire:model="price"
                  placeholder="{{ _app('price') }}">
                <label for="description">{{ _app('description') }}</label>
                <textarea class="form-control mt-2 bg-transparent" wire:model="description" placeholder="{{ _app('description') }}"></textarea>

                <label for="start_time">{{ _app('start_time') }}</label>
                <input class="form-control mt-2 bg-transparent" type="time" wire:model="start_time">
                <label for="end_time">{{ _app('end_time') }}</label>
                <input class="form-control mt-2 bg-transparent" type="time" wire:model="end_time">

                <label for="starting_day">{{ _app('starting_day') }}</label>
                <input class="form-control mt-2 bg-transparent" type="date" wire:model="starting_day">
                <label for="closing_day">{{ _app('closing_day') }}</label>
                <input class="form-control mt-2 bg-transparent" type="date" wire:model="closing_day">

                <div class="form-floating mb-3 mt-3">
                  <select class="form-select" aria-label="categories" wire:model.live='organizer_id'>
                    <option selected>{{ _app('Choose') }}</option>
                    @foreach (Auth::user()->client->staffs() as $user)
                      <option value="{{ $user->id }}">
                        {{ $user->name }}
                      </option>
                    @endforeach
                  </select>
                  <label for="organizer_id">{{ _app('Organizer') }}</label>
                  @error('organizer_id')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <label for="type">{{ _app('type') }}</label>
                <select class="form-select mt-2 bg-transparent" wire:model.live="type">
                  <option value="">{{ _app('choose') }}</option>
                  <option value="online">{{ _app('online') }}</option>
                  <option value="offline">{{ _app('offline') }}</option>
                </select>

                <div class="form-floating mb-3 mt-3">
                  <select class="form-select" aria-label="categories" wire:model.live='country_id'
                    {{ $is_edit ? 'readonly disabled' : 'required' }}>
                    <option selected>{{ _app('Choose') }}</option>
                    @foreach ($countries as $country)
                      <option value="{{ $country->id }}" wire:click='change_country("{{ write($country->id) }}")'>
                        {{ $country->name }}
                      </option>
                    @endforeach
                  </select>
                  <label for="country_id">{{ _app('Country') }}</label>
                  @error('country_id')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <div class="form-floating mb-3">
                  <select class="form-select" aria-label="categories" wire:model.live='state_id'
                    {{ $is_edit ? 'readonly disabled' : 'required' }}>
                    <option selected>{{ _app('Choose') }}</option>
                    @foreach ($states as $state)
                      <option value="{{ $state->id }}" wire:click='change_state("{{ write($state->id) }}")'>
                        {{ $state->name }}
                      </option>
                    @endforeach
                  </select>
                  <label for="state_id">{{ _app('State') }}</label>
                  @error('state_id')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
                <div class="form-floating mb-3">
                  <select class="form-select" aria-label="categories" wire:model.live='city_id'
                    {{ $is_edit ? 'readonly disabled' : 'required' }}>
                    <option selected>{{ _app('Choose') }}</option>
                    @foreach ($cities as $city)
                      <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                  </select>
                  <label for="city_id">{{ _app('City') }}</label>
                  @error('city_id')
                    <small class="text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button"
                wire:click="close_add_event_modal">{{ _app('cancel') }}</button>
              <button class="btn btn-primary mt-2" wire:click="{{ $is_edit ? 'update_event' : 'create_event' }}">
                {{ $is_edit ? _app('update_event') : _app('add_event') }}
              </button>
            </div>
          </div>
        </div>
      </div>
    @endif

    @if ($event_delete_modal)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog">
          <div class="modal-content bg-secondary">
            <div class="modal-header">
              <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
              <button class="close" type="button" wire:click="close_delete_event_modal">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ _app('msg_delete') }}?</p>
              <h3 class="text-primary text-center">{{ $event->name }}</h3>
              <input class="form-control" type="password" wire:model.live="password"
                placeholder="Enter your password to confirm">
              @error($password)
                <span>{{ $message }}</span>
              @enderror
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button"
                wire:click="close_delete_event_modal">{{ _app('cancel') }}</button>
              <button class="btn btn-danger" type="button" wire:click="confirm_delete_event"><i
                  class="bi bi-trash"></i></button>
            </div>
          </div>
        </div>
      </div>
    @endif
    <div class="table-responsive">

      <table class="table-striped table-hover table-sm table">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th style="width: 10vw;">{{ _app('title') }}</th>
            {{-- <th style="width: 35vw;">{{ _app('description') }}</th> --}}
            <th>{{ _app('date') }}</th>
            <th>{{ _app('time') }}</th>
            <th>{{ _app('status') }}</th>
            <th>{{ _app('price') }}</th>
            <th>{{ _app('organizer') }}</th>
            <th>{{ _app('tickets') }}</th>
            <th style="text-align: right;">{{ _app('Actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($events as $index => $event)
            <tr>
              <td>
                {{ $loop->iteration }}
              </td>
              <td>{{ $event->title }} </td>
              <td>
                {{ \Carbon\Carbon::parse($event->starting_day)->format('jS M Y') }}
                to
                {{ \Carbon\Carbon::parse($event->closing_day)->format('jS M Y') }}
              </td>
              <td>
                {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                to
                {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
              </td>

              <td>{{ $event->status }} </td>
              <td>{{ $event->price }} </td>
              <td>{{ $event->organizer->name }} </td>
              <td>{{ $event->tickets->count() }} </td>
              <td style="text-align: right;">
                <button class="btn btn-sm btn-{{ $event->status == 'confirmed' ? 'success' : 'outline-success' }}"
                  wire:click='confirm_event("{{ $event->id }}")'><i class="bi bi-eye"></i></button>
                <button class="btn btn-sm btn-outline-primary" wire:click="edit_event({{ $event->id }})">
                  <i class="bi bi-pen"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" wire:click="delete_event({{ $event->id }})">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-muted text-center" colspan="9">No tasks found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">
    </div>

  </div>
</div>
