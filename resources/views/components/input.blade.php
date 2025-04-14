@props(['disabled' => false])

<input style="background-color: rgba(0, 0, 0, 0); color: #f10000 !important; border: 2px solid rgb(255, 0, 0);"
  {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'form-control']) !!}>
