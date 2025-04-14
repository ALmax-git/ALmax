@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
  <div class="card m-4 bg-black p-4" style="background-color: black !important;">
    <div class="card-header bg-black">
      {{ $title }}
    </div>

    <div class="card-body bg-black">
      {{ $content }}
    </div>
  </div>

  <div class="card-footer bg-black">
    {{ $footer }}
  </div>
</x-modal>
