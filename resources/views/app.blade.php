@extends('layouts.app')
@section('content')
  @if (Auth::user())
    @if ($model == 'pos')
      <livewire:pos />
    @else
      @if (isset($email))
        @php
          $model = 'User';
        @endphp
        <livewire:app :model='$model' :email='$email' />
      @else
        <livewire:app />
      @endif
    @endif
  @else
    <livewire:auth.auth />
  @endif
@endsection
