<div class="container">
  <div class="login-box">
    <h2>ALmax</h2>
    <x-validation-errors class="mb-4" />

    @session('status')
      <div class="mb-4 text-sm font-medium text-green-600">
        {{ $value }}
      </div>
    @endsession
    @switch($tab)
      @case('Login')
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="input-box">

            <x-input id="email" name="email" type="email" :value="old('email')" required autofocus
              autocomplete="username" />
            <x-label for="email" value="{{ __('Email') }}" />
          </div>
          <div class="input-box">
            <x-input id="password" name="password" type="password" required autocomplete="current-password" />
            <x-label for="password" value="{{ __('Password') }}" />
          </div>

          <div class="forgot-pass">
            @if (Route::has('password.request'))
              <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
              </a>
            @endif
          </div>
          <button class="btn" type="submit"> {{ __('Log in') }}</button>
          <div class="signup-link">
            <a href="#" wire:click='toggle_tab("Register")'>Create Account</a>
          </div>
        </form>
      @break

      @case('Register')
        <form method="POST" action="{{ route('register') }}">
          @csrf
          <div class="input-box">
            <x-input class="form-control" id="name" name="name" type="text" :value="old('name')" required autofocus
              autocomplete="name" />
            <x-label for="name" value="{{ __('Name') }}" />
          </div>
          <div class="input-box">
            <x-input id="email" name="email" type="email" :value="old('email')" required autofocus
              autocomplete="username" />
            <x-label for="email" value="{{ __('Email') }}" />
          </div>
          <div class="input-box">
            <x-input id="password" name="password" type="password" required autocomplete="current-password" />
            <x-label for="password" value="{{ __('Password') }}" />
          </div>
          <div class="input-box">
            <x-input class="form-control" id="password_confirmation" name="password_confirmation" type="password" required
              autocomplete="new-password" />
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
          </div>

          <button class="btn" type="submit"> {{ __('Register') }}</button>
          <div class="signup-link">
            <a href="{{ route('login') }}">Have Account</a>
          </div>
        </form>
      @break

      @default
    @endswitch
  </div>

  <span style="--i:0;"></span>
  <span style="--i:1;"></span>
  <span style="--i:2;"></span>
  <span style="--i:3;"></span>
  <span style="--i:4;"></span>
  <span style="--i:5;"></span>
  <span style="--i:6;"></span>
  <span style="--i:7;"></span>
  <span style="--i:8;"></span>
  <span style="--i:9;"></span>
  <span style="--i:10;"></span>
  <span style="--i:11;"></span>
  <span style="--i:12;"></span>
  <span style="--i:13;"></span>
  <span style="--i:14;"></span>
  <span style="--i:15;"></span>
  <span style="--i:16;"></span>
  <span style="--i:17;"></span>
  <span style="--i:18;"></span>
  <span style="--i:19;"></span>
  <span style="--i:20;"></span>
  <span style="--i:21;"></span>
  <span style="--i:22;"></span>
  <span style="--i:23;"></span>
  <span style="--i:24;"></span>
  <span style="--i:25;"></span>
  <span style="--i:26;"></span>
  <span style="--i:27;"></span>
  <span style="--i:28;"></span>
  <span style="--i:29;"></span>
  <span style="--i:30;"></span>
  <span style="--i:31;"></span>
  <span style="--i:32;"></span>
  <span style="--i:33;"></span>
  <span style="--i:34;"></span>
  <span style="--i:35;"></span>
  <span style="--i:36;"></span>
  <span style="--i:37;"></span>
  <span style="--i:38;"></span>
  <span style="--i:39;"></span>
  <span style="--i:40;"></span>
  <span style="--i:41;"></span>
  <span style="--i:42;"></span>
  <span style="--i:43;"></span>
  <span style="--i:44;"></span>
  <span style="--i:45;"></span>
  <span style="--i:46;"></span>
  <span style="--i:47;"></span>
  <span style="--i:48;"></span>
  <span style="--i:49;"></span>
</div>
