<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary m-2']) }}>
  {{ $slot }}
</button>
