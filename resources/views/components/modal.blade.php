@props(['id', 'maxWidth'])

@php
  $id = $id ?? md5($attributes->wire('model'));

  $maxWidth = [
      'sm' => 'sm:max-w-sm',
      'md' => 'sm:max-w-md',
      'lg' => 'sm:max-w-lg',
      'xl' => 'sm:max-w-xl',
      '2xl' => 'sm:max-w-2xl',
  ][$maxWidth ?? '2xl'];
@endphp

<div class="card mt-4 bg-black p-2" id="{{ $id }}" style="display: none; background-color: black !important;"
  x-data="{ show: @entangle($attributes->wire('model')) }" x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show">
  <div class="bg-black" x-show="show" x-on:click="show = false" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-black opacity-75 dark:bg-gray-900"></div>
  </div>

  <div
    class="{{ $maxWidth }} mb-6 transform overflow-hidden rounded-lg bg-black shadow-xl transition-all sm:mx-auto sm:w-full dark:bg-gray-800"
    x-show="show" x-trap.inert.noscroll="show" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
    {{ $slot }}
  </div>
</div>
