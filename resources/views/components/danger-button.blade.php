<button style="border: 1px solid red !important ; color: rgb(255, 255, 255);"
  {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-primary  uppercase']) }}>
  {{ $slot }}
</button>
