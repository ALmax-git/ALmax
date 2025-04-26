<div class="container-fluid px-4 pt-4">
  <div class="bg-secondary h-100 rounded p-4">
    <h6 class="mb-4">{{ _app('create_new_business') }}</h6>
    <div class="form-floating mb-3">
      <input class="form-control" type="text" wire:model.live='name' placeholder="{{ _app('business_name') }}">
      <label for="name">{{ _app('business_name') }}</label>
      @error('name')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>
    <div class="form-floating mb-3">
      <input class="form-control" type="email" wire:model.live='email' placeholder="client@example.com">
      <label for="email">{{ _app('Email') }}</label>
      @error('email')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>
    <div class="form-floating mb-3">
      <input class="form-control" type="text" wire:model.live='tagline' placeholder="Code your dreams into reality">
      <label for="tagline">{{ _app('tagline') }}</label>
      @error('tagline')
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
      <select class="form-select" aria-label="categories" wire:model.live='country_id'>
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
      <select class="form-select" aria-label="categories" wire:model.live='state_id'>
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
      <select class="form-select" aria-label="categories" wire:model.live='city_id'>
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
      <select class="form-select" aria-label="categories" wire:model.live='category_id'>
        <option selected>{{ _app('Choose') }}</option>
        @foreach ($business_categories as $category)
          <option value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
      </select>
      <label for="category_id">{{ _app('business_category') }}</label>
      @error('category_id')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>
    <div class="form-floating mb-3">
      <textarea class="form-control" wire:model.live='vision' placeholder="{{ _app('placeholder_vision') }}"></textarea>
      <label for="vision">{{ _app('Vision') }}</label>
      @error('vision')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>
    <div class="form-floating mb-3">
      <textarea class="form-control" wire:model.live='mission' placeholder="{{ _app('placeholder_mission') }}"></textarea>
      <label for="mission">{{ _app('Mission') }}</label>
      @error('mission')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>
    <div class="form-floating mb-3">
      <textarea class="form-control" wire:model.live='description' placeholder="Tell us More about you business"></textarea>
      <label for="description">{{ _app('Description') }}</label>
      @error('description')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    </div>
    @if (!$is_editing)
      <hr>
      @if ($logo)
        <img class="rounded-circle center" src="{{ $logo->temporaryUrl() }}" alt=""
          style="width: 60px; height: 60px;">
      @endif

      <label class="btn btn-primary mb-4 me-2" for="logo" tabindex="0">
        <span class="d-none d-sm-block">{{ _app('upload_logo') }}</span>
        <i class="bx bx-upload d-block d-sm-none"></i>
        <input class="account-file-input" id="logo" type="file" wire:model="logo" hidden
          accept="image/png, image/jpeg" />
      </label>
      @error('logo')
        <small class="text-danger">{{ $message }}</small>
      @enderror
    @endif
    <hr>
    @if ($is_editing)
      <button class="btn btn-primary" type="submit" wire:click='update'>{{ _app('Update') }}</button>
    @else
      <button class="btn btn-primary" type="submit" wire:click='submit'>{{ _app('Create') }}</button>
      <button class="btn btn-primary" type="reset" wire:click='cancel'>{{ _app('Cancel') }}</button>
    @endif
  </div>
</div>
