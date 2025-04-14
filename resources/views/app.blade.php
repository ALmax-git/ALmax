@extends('layouts.app')
@section('content')
  @if (Auth::user())
    <livewire:app />
  @else
    <livewire:auth.auth />
  @endif
@endsection
