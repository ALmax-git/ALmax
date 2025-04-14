<div class="h-75 m-3 w-full bg-black"
  style="border-left: 2px solid #f40202; overflow-x: scroll; height: 65vh !important; padding: 15px; border-right: 2px solid #f40202;">
  <div class="cards flex flex-wrap">
    <div class="row">

      @if (Laravel\Fortify\Features::canUpdateProfileInformation())
        @livewire('profile.update-profile-information-form')

        <x-section-border />
      @endif

      @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        <div class="mt-10 sm:mt-0">
          @livewire('profile.update-password-form')
        </div>

        <x-section-border />
      @endif

      @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <div class="mt-10 sm:mt-0">
          @livewire('profile.two-factor-authentication-form')
        </div>

        <x-section-border />
      @endif

      <div class="mt-10 sm:mt-0">
        @livewire('profile.logout-other-browser-sessions-form')
      </div>

      @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
        <x-section-border />

        <div class="mt-10 sm:mt-0">
          @livewire('profile.delete-user-form')
        </div>
      @endif
    </div>
  </div>
</div>
