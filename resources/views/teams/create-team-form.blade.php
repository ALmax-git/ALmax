<x-form-section submit="createTeam">
  <x-slot name="title">
    {{ __('Team Details') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Create a new team to collaborate with others on projects.') }}
  </x-slot>

  <x-slot name="form">
    <div class="col-span-6">
      <x-label value="{{ __('Team Owner') }}" />

      <div class="mt-2 flex items-center">
        <img class="size-12 rounded-full object-cover" src="{{ $this->user->profile_photo_url }}"
          alt="{{ $this->user->name }}">

        <div class="ms-4 leading-tight">
          <div class="text-gray-900">{{ $this->user->name }}</div>
          <div class="text-sm text-gray-700">{{ $this->user->email }}</div>
        </div>
      </div>
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-label for="name" value="{{ __('Team Name') }}" />
      <x-input class="form-control" id="name" type="text" wire:model="state.name" autofocus />
      <x-input-error class="mt-2" for="name" />
    </div>
  </x-slot>

  <x-slot name="actions">
    <x-button>
      {{ __('Create') }}
    </x-button>
  </x-slot>
</x-form-section>
