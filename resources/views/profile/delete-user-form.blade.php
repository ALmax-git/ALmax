<x-action-section style="background-color: red !important;">
  <x-slot name="title">
    {{ _app('del_acc') }}
  </x-slot>

  <x-slot name="description">
    {{ _app('delete_acc_info') }}
  </x-slot>

  <x-slot name="content">
    <div class="max-w-xl text-sm text-white dark:text-gray-400">
      {{ _app('delete_warning') }}
    </div>

    <div class="mt-5">
      <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
        {{ _app('del_acc') }}
      </x-danger-button>
    </div>

    <!-- Delete User Confirmation Modal -->
    <x-dialog-modal wire:model.live="confirmingUserDeletion">
      <x-slot name="title">
        {{ _app('del_acc') }}
      </x-slot>

      <x-slot name="content">
        {{ _app('warning_del_acc') }}

        <div class="mt-4" x-data="{}"
          x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
          <x-input class="form-control" type="password" autocomplete="current-password"
            placeholder="{{ _app('Password') }}" x-ref="password" wire:model="password"
            wire:keydown.enter="deleteUser" />

          <x-input-error class="mt-2" for="password" />
        </div>
      </x-slot>

      <x-slot name="footer">
        <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
          {{ _app('Cancel') }}
        </x-secondary-button>

        <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
          {{ _app('del_acc') }}
        </x-danger-button>
      </x-slot>
    </x-dialog-modal>
  </x-slot>
</x-action-section>
