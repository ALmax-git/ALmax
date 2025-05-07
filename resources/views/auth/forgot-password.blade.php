<x-guest-layout>
  <x-authentication-card>
    <x-slot name="logo">
      <x-authentication-card-logo />
    </x-slot>

    <div class="mb-4 text-sm text-gray-600">
      {{ _app('forgot_password_info') }}
    </div>

    @session('status')
      <div class="mb-4 text-sm font-medium text-green-600">
        {{ $value }}
      </div>
    @endsession

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.email') }}">
      @csrf

      <div class="block">
        <x-label for="email" value="{{ _app('Email') }}" />
        <x-input class="mt-1 block w-full" id="email" name="email" type="email" :value="old('email')" required
          autofocus autocomplete="username" />
      </div>

      <div class="mt-4 flex items-center justify-end">
        <x-button>
          {{ _app('email_reset_link') }}
        </x-button>
      </div>
    </form>
  </x-authentication-card>
</x-guest-layout>
