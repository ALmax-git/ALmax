@props(['disabled' => false])

<input style="background-color: rgba(0, 0, 0, 0); color: #1602f4 !important; border: 2px solid rgb(25, 0, 255);"
  {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!}>
