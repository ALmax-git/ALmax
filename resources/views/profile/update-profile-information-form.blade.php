<x-form-section submit="updateProfileInformation">
  <x-slot name="title">
    {{ __('Profile Information') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Update your account\'s profile information and email address.') }}
  </x-slot>

  <x-slot name="form">
    <!-- Profile Photo -->
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
      <div class="col-span-6 sm:col-span-4" x-data="{ photoName: null, photoPreview: null }">
        <!-- Profile Photo File Input -->
        <input class="hidden" id="photo" type="file" wire:model.live="photo" x-ref="photo"
          x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

        <x-label for="photo" value="{{ __('Photo') }}" />

        <!-- Current Profile Photo -->
        <div class="mt-2" x-show="! photoPreview">
          <img class="rounded-circle me-lg-2" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
            style="width: 40px; height: 40px;">
        </div>

        <!-- New Profile Photo Preview -->
        <div class="mt-2" style="display: none;" x-show="photoPreview">
          <span class="block size-20 rounded-full bg-cover bg-center bg-no-repeat"
            x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
          </span>
        </div>

        <x-secondary-button class="btn btn-primary me-2 mt-2" type="button" x-on:click.prevent="$refs.photo.click()">
          {{ __('Select A New Photo') }}
        </x-secondary-button>

        @if ($this->user->profile_photo_path)
          <x-secondary-button class="btn btn-primary mt-2" type="button" wire:click="deleteProfilePhoto">
            {{ __('Remove Photo') }}
          </x-secondary-button>
        @endif

        <x-input-error class="mt-2" for="photo" />
      </div>
    @endif

    <!-- Name -->
    <div class="col-span-6 sm:col-span-4">
      <x-label for="name" value="{{ __('Name') }}" />
      <x-input class="form-control" id="name" type="text" wire:model="state.name" required
        autocomplete="name" />
      <x-input-error class="mt-2" for="name" />
    </div>

    <!-- Username -->
    {{-- <div class="col-span-6 sm:col-span-4">
      <x-label for="username" value="{{ __('Username') }}" />
      <x-input class="form-control" id="username" type="text" wire:model="state.username" required
        autocomplete="username" />
      <x-input-error class="mt-2" for="username" />
    </div> --}}

    <!-- Email -->
    <div class="col-span-6 sm:col-span-4">
      <x-label for="email" value="{{ __('Email') }}" />
      <x-input class="form-control" id="email" type="email" wire:model="state.email" required
        autocomplete="username" />
      <x-input-error class="mt-2" for="email" />

      @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) &&
              !$this->user->hasVerifiedEmail())
        <p class="mt-2 text-sm dark:text-white">
          {{ __('Your email address is unverified.') }}

          <button
            class="rounded-md text-sm text-white underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:text-gray-400 dark:hover:text-gray-100 dark:focus:ring-offset-gray-800"
            type="button" wire:click.prevent="sendEmailVerification">
            {{ __('Click here to re-send the verification email.') }}
          </button>
        </p>

        @if ($this->verificationLinkSent)
          <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to your email address.') }}
          </p>
        @endif
      @endif
    </div>
  </x-slot>

  <x-slot name="actions">
    <x-action-message class="me-3" on="saved">
      {{ __('Saved.') }}
    </x-action-message>

    <x-button wire:loading.attr="disabled" wire:target="photo">
      {{ __('Save') }}
    </x-button>
  </x-slot>
</x-form-section>
