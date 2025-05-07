<x-form-section submit="updatePassword">
  <x-slot name="title">
    {{ _app('upd_pwd') }}
  </x-slot>

  <x-slot name="description">
    {{ _app('secure_password') }}
  </x-slot>

  <x-slot name="form">
    <div class="col-span-6 sm:col-span-4">
      <x-label for="current_password" value="{{ _app('Current_Password') }}" />
      <x-input class="form-control" id="current_password" type="password" wire:model="state.current_password"
        autocomplete="current-password" />
      <x-input-error class="mt-2" for="current_password" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-label for="password" value="{{ _app('New_Password') }}" />
      <x-input class="form-control" id="password" type="password" wire:model="state.password"
        autocomplete="new-password" />
      <x-input-error class="mt-2" for="password" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-label for="password_confirmation" value="{{ _app('confirm_password_info') }}" />
      <x-input class="form-control" id="password_confirmation" type="password" wire:model="state.password_confirmation"
        autocomplete="new-password" />
      <x-input-error class="mt-2" for="password_confirmation" />
    </div>
  </x-slot>

  <x-slot name="actions">
    <x-action-message class="me-3" on="saved">
      {{ _app('Saved.') }}
    </x-action-message>

    <x-button>
      {{ _app('Save') }}
    </x-button>
  </x-slot>
</x-form-section>
