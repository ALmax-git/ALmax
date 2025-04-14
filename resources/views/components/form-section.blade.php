@props(['submit'])

<div style="background-color: rgb(0, 0, 0) !important;" {{ $attributes->merge(['class' => 'bg-black']) }}>
  <x-section-title>
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="description">{{ $description }}</x-slot>
  </x-section-title>

  <div class="mt-5 md:col-span-2 md:mt-0">
    <form wire:submit="{{ $submit }}">
      <div class="{{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
        <div class="grid grid-cols-6 gap-6">
          {{ $form }}
        </div>
      </div>

      @if (isset($actions))
        <div class="flex items-center justify-end">
          {{ $actions }}
        </div>
      @endif
    </form>
  </div>
</div>
