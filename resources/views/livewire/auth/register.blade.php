<form class="mb-3" id="formAuthentication" method="POST" action="{{ route('register') }}">
  @csrf
  <h4 class="mb-2">Welcome to ALmax! 👋</h4>
  <div>
    <x-label for="name" value="{{ __('Username') }}" />
    <input class="form-control" id="name" name="name" type="text" wire:input='validate_name' wire:model='name'
      :value="old('name')" required autofocus autocomplete="name" />
    <span class="text-info cursor-pointer">{{ $name_status }}</span>
  </div>

  <div class="mb-3">
    <x-label for="email" value="{{ __('Email') }}" />
    <input class="form-control" id="email" name="email" type="email" wire:input='validate_email'
      wire:model='email' :value="old('email')" required autocomplete="email" />
    <span class="text-info cursor-pointer">{{ $email_status }}</span>
  </div>

  <div class="form-password-toggle mb-3">
    <x-label for="password" value="{{ __('Password') }}" />
    <div class="input-group input-group-merge">
      <input class="form-control" id="password" id="password" name="password" type="password" wire:model='password'
        wire:change='validate_password' required autocomplete="new-password" />
      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
    <span class="text-info cursor-pointer">{{ $password_status }}</span>
  </div>

  <div class="mb-3">
    <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
    <div class="input-group input-group-merge">
      <input class="form-control" id="password_confirmation" name="password_confirmation" type="password"
        wire:model='$comfirmed_password' wire:change='validate_confirm_password' required autocomplete="new-password" />
      {{-- <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span> --}}
    </div>
    <span class="text-info cursor-pointer">{{ $password_status }}</span>
  </div>

  @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
    <div class="mb-3">
      <x-label for="terms">
        <div class="d-flex items-center">
          <x-checkbox id="terms" name="terms" wire:click='validate_form' required />

          <div class="ms-2">
            {!! __(' I agree to the :terms_of_service and :privacy_policy', [
                'terms_of_service' =>
                    '<a target="_blank" href="' .
                    route('terms.show') .
                    '"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                    __('Terms
                                    of Service') .
                    '</a>',
                'privacy_policy' =>
                    '<a target="_blank" href="' .
                    route('policy.show') .
                    '"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">' .
                    __('Privacy
                                    Policy') .
                    '</a>',
            ]) !!}
          </div>
        </div>
      </x-label>
    </div>
  @endif
  <div class="mb-3">
    <button class="btn btn-primary d-grid w-100" type="submit"
      wire:confirm="Are you sure your input are correct?">Create Account</button>
  </div>
  <div class="mt-4 flex justify-end">
    <a class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
      href="{{ route('gate') }}">
      {{ __('Already registered?') }}
    </a>

  </div>
</form>
