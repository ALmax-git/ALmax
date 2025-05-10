@extends('layouts.auth')
@section('content')
  {{-- <x-validation-errors class="mb-4" /> --}}

  @session('status')
    <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
      {{ $value }}
    </div>
  @endsession

  <form class="mb-3" id="formAuthentication" method="POST" action="{{ route('login') }}">
    @csrf
    <h2>Hay there! {{ session('username') ?? '' }}👋</h2>
    <p>Please sign-in to your account and start the adventure </p>
    <div>
      {{-- <x-label for="email" value="{{ __('Email') }}" /> --}}
      <x-input class="form-control" id="email" name="email" type="{{ session('email') != '' ? 'hidden' : 'email' }}"
        value="{{ session('email') ?? '' }}" required />
    </div>

    <div class="mt-4">
      <x-label for="password" value="{{ __('Password') }}" />
      <x-input class="form-control" id="password" name="password" type="password" required
        autocomplete="current-password" />
    </div>

    <div class="form-check form-switch mt-4 block">
      <label class="flex items-center" for="remember_me">
        <x-checkbox class="form-check-input" id="remember_me" name="remember" />
        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
      </label>
    </div>

    <div class="row mt-3">
      <div class="d-grid col-lg-6 mx-auto gap-2">
        <button class="btn btn-primary btn-lg" type="submit">
          {{ __('Log in') }}
        </button>
      </div>
    </div>
    <div class="d-flex mt-4 items-center justify-end">
      @if (Route::has('password.request'))
        <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
          href="{{ route('password.request') }}">
          {{ __('🤔Forgot your password?') }}
        </a>
      @endif
      &nbsp;&nbsp;&nbsp;&nbsp;
      <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
        href="{{ route('register') }}">
        {{ __('Nop I am New Here!') }}
      </a>
    </div>
  </form>
@endsection
