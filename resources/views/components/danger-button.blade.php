<button style="border: 1px solid #1602f4 !important ; color: rgb(255, 255, 255);"
  {{ $attributes->merge(['type' => 'button', 'class' => 'btn btn-primary  uppercase']) }}>
  {{ $slot }}
</button>
