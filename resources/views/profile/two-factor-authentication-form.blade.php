<x-action-section>
  <x-slot name="title">
    {{ _app('two_fa') }}
  </x-slot>

  <x-slot name="description">
    {{ _app('add_2fa') }}
  </x-slot>

  <x-slot name="content">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      @if ($this->enabled)
        @if ($showingConfirmation)
          {{ _app('finish_2fa') }}
        @else
          {{ _app('enabled_2fa') }}
        @endif
      @else
        {{ _app('2fa_not_enabled') }}
      @endif
    </h3>

    <div class="mt-3 max-w-xl text-sm text-white dark:text-gray-400">
      <p>
        {{ _app('2fa_explain') }}
      </p>
    </div>

    @if ($this->enabled)
      @if ($showingQrCode)
        <div class="mt-4 max-w-xl text-sm text-white dark:text-gray-400">
          <p class="font-semibold">
            @if ($showingConfirmation)
              {{ _app('setup_2fa') }}
            @else
              {{ _app('enabled_info_2fa') }}
            @endif
          </p>
        </div>

        <div class="mt-4 inline-block bg-black p-2">
          {!! $this->user->twoFactorQrCodeSvg() !!}
        </div>

        <div class="mt-4 max-w-xl text-sm text-white dark:text-gray-400">
          <p class="font-semibold">
            {{ _app('Setup_Key') }}: {{ decrypt($this->user->two_factor_secret) }}
          </p>
        </div>

        @if ($showingConfirmation)
          <div class="mt-4">
            <x-label for="code" value="{{ _app('Code') }}" />

            <x-input class="mt-1 block w-1/2" id="code" name="code" type="text" inputmode="numeric" autofocus
              autocomplete="one-time-code" wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication" />

            <x-input-error class="mt-2" for="code" />
          </div>
        @endif
      @endif

      @if ($showingRecoveryCodes)
        <div class="mt-4 max-w-xl text-sm text-white dark:text-gray-400">
          <p class="font-semibold">
            {{ _app('store_recovery_codes') }}
          </p>
        </div>

        <div
          class="mt-4 grid max-w-xl gap-1 rounded-lg bg-gray-100 px-4 py-4 font-mono text-sm dark:bg-gray-900 dark:text-gray-100">
          @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
            <div>{{ $code }}</div>
          @endforeach
        </div>
      @endif
    @endif

    <div class="mt-5">
      @if (!$this->enabled)
        <x-confirms-password wire:then="enableTwoFactorAuthentication">
          <x-button type="button" wire:loading.attr="disabled">
            {{ _app('Enable') }}
          </x-button>
        </x-confirms-password>
      @else
        @if ($showingRecoveryCodes)
          <x-confirms-password wire:then="regenerateRecoveryCodes">
            <x-secondary-button class="me-3">
              {{ _app('regen_recovery') }}
            </x-secondary-button>
          </x-confirms-password>
        @elseif ($showingConfirmation)
          <x-confirms-password wire:then="confirmTwoFactorAuthentication">
            <x-button class="me-3" type="button" wire:loading.attr="disabled">
              {{ _app('Confirm') }}
            </x-button>
          </x-confirms-password>
        @else
          <x-confirms-password wire:then="showRecoveryCodes">
            <x-secondary-button class="me-3">
              {{ _app('show_recovery') }}
            </x-secondary-button>
          </x-confirms-password>
        @endif

        @if ($showingConfirmation)
          <x-confirms-password wire:then="disableTwoFactorAuthentication">
            <x-secondary-button wire:loading.attr="disabled">
              {{ _app('Cancel') }}
            </x-secondary-button>
          </x-confirms-password>
        @else
          <x-confirms-password wire:then="disableTwoFactorAuthentication">
            <x-danger-button wire:loading.attr="disabled">
              {{ _app('Disable') }}
            </x-danger-button>
          </x-confirms-password>
        @endif

      @endif
    </div>
  </x-slot>
</x-action-section>
