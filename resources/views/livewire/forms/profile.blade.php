<div>
  <div class="flex justify-between md:col-span-1">
    <div class="mb-1">
      <h3 style="background-color: black !important; color: rgb(0, 64, 255);">{{ _app('profile_bio') }}</h3>

      <p class="mt-1 text-sm text-white dark:text-gray-400" style="color: white !important;">
        {{-- {{ $description }} --}}
      </p>
    </div>
    <div class="form-floating">
      <div class="form-floating mb-3">
        <input class="form-control" type="text" wire:model.live='first_name' placeholder="John">
        <label for="first_name">{{ _app('first_name') }}</label>
        @error('first_name')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" type="text" wire:model.live='surname' placeholder="Doe">
        <label for="surname">{{ _app('surname') }}</label>
        @error('surname')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" type="text" wire:model.live='last_name' placeholder="">
        <label for="last_name">{{ _app('last_name') }}</label>
        @error('last_name')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <div class="form-floating mb-3">
        <input class="form-control" type="tel" wire:model.live='telephone' placeholder="+234 80 0000 0000">
        <label for="telephone">{{ _app('Telephone') }}</label>
        @error('telephone')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <div class="form-floating mb-3">
        <select class="form-control" aria-label="categories" wire:model.live='country_id'>
          <option selected>{{ _app('Choose') }}</option>
          @foreach ($countries as $country)
            <option value="{{ $country->id }}" wire:click='change_country("{{ write($country->id) }}")'>
              {{ $country->flag }} {{ $country->name }}
            </option>
          @endforeach
        </select>
        <label for="country_id">{{ _app('Country') }}</label>
        @error('country_id')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <div class="form-floating mb-3">
        <select class="form-control" aria-label="categories" wire:model.live='state_id'>
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
        <select class="form-control" aria-label="categories" wire:model.live='city_id'>
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
      <div class="form-floating mb-3">
        <select class="form-control" aria-label="visibility" wire:model.live='visibility'>
          <option selected>{{ _app('Choose') }}</option>
          <option value="public">{{ _app('public') }} </option>
          <option value="protected">{{ _app('protected') }} </option>
          <option value="private">{{ _app('private') }} </option>
        </select>
        <label for="visibility">{{ _app('profile_visibility') }}</label>
        @error('visibility')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <div class="form-floating mb-3">
        <textarea class="form-control" wire:model.live='bio' placeholder="{{ _app('bio') }}"></textarea>
        <label for="bio">{{ _app('bio') }}</label>
        @error('bio')
          <small class="text-danger">{{ $message }}</small>
        @enderror
      </div>
      <button class="btn btn-info" wire:click='update_profile'>Save</button>
    </div>
  </div>
</div>
