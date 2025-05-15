@props(['disabled' => false])

<input style="background-color: rgba(0, 0, 0, 0); color: #02001a !important; border: 2px solid rgb(9, 1, 85);"
  {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!}>
