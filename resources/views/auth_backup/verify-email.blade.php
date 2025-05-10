<x-guest-layout>
  <x-authentication-card>
    <x-slot name="logo">
      <x-authentication-card-logo />
    </x-slot>

    <div class="mb-4 text-sm text-gray-600">
      {{ __('Before continuing, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
      <div class="mb-4 text-sm font-medium text-green-600">
        {{ __('A new verification link has been sent to the email address you provided in your profile settings.') }}
      </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
      <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <div>
          <x-button type="submit">
            {{ __('Resend Verification Email') }}
          </x-button>
        </div>
      </form>

      <div>
        <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
          href="{{ route('profile.show') }}">
          {{ __('Edit Profile') }}</a>

        <form class="inline" method="POST" action="{{ route('logout') }}">
          @csrf

          <button
            class="ms-2 rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            type="submit">
            {{ __('Log Out') }}
          </button>
        </form>
      </div>
    </div>
  </x-authentication-card>
</x-guest-layout>
