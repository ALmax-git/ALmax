<div style="background-color: rgb(0, 0, 0) !important;" {{ $attributes->merge(['class' => 'bg-black']) }}>
  <x-section-title>
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="description">{{ $description }}</x-slot>
  </x-section-title>

  <div class="mt-2 md:col-span-2 md:mt-0">
    <div class="bg-black px-4 py-5 shadow sm:rounded-lg sm:p-6 dark:bg-gray-800">
      {{ $content }}
    </div>
  </div>
</div>
