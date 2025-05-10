@extends('layouts.app')
@section('content')
  @if (Auth::user())
    @if (isset($email))
      @php
        $model = 'User';
      @endphp
      <livewire:app :model='$model' :email='$email' />
    @else
      <livewire:app />
    @endif
  @else
    <livewire:auth.auth />
  @endif
@endsection
