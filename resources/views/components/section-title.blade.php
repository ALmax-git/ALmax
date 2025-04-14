<div class="flex justify-between md:col-span-1">
  <div class="mb-1">
    <h3 style="background-color: black !important; color: rgb(255, 0, 0);">{{ $title }}</h3>

    <p class="mt-1 text-sm text-white dark:text-gray-400" style="color: white !important;">
      {{ $description }}
    </p>
  </div>

  <div class="mb-1">
    {{ $aside ?? '' }}
  </div>
</div>
