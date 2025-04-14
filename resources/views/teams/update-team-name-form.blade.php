<x-form-section submit="updateTeamName">
  <x-slot name="title">
    {{ __('Team Name') }}
  </x-slot>

  <x-slot name="description">
    {{ __('The team\'s name and owner information.') }}
  </x-slot>

  <x-slot name="form">
    <!-- Team Owner Information -->
    <div class="col-span-6">
      <x-label value="{{ __('Team Owner') }}" />

      <div class="mt-2 flex items-center">
        <img class="size-12 rounded-full object-cover" src="{{ $team->owner->profile_photo_url }}"
          alt="{{ $team->owner->name }}">

        <div class="ms-4 leading-tight">
          <div class="text-gray-900">{{ $team->owner->name }}</div>
          <div class="text-sm text-gray-700">{{ $team->owner->email }}</div>
        </div>
      </div>
    </div>

    <!-- Team Name -->
    <div class="col-span-6 sm:col-span-4">
      <x-label for="name" value="{{ __('Team Name') }}" />

      <x-input class="form-control" id="name" type="text" wire:model="state.name" :disabled="!Gate::check('update', $team)" />

      <x-input-error class="mt-2" for="name" />
    </div>
  </x-slot>

  @if (Gate::check('update', $team))
    <x-slot name="actions">
      <x-action-message class="me-3" on="saved">
        {{ __('Saved.') }}
      </x-action-message>

      <x-button>
        {{ __('Save') }}
      </x-button>
    </x-slot>
  @endif
</x-form-section>
