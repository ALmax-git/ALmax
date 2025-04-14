@props(['on'])

<div style="display: none; background-color: rgba(0, 0, 0, 0) !important; color: rgb(251, 18, 18);"
  x-data="{ shown: false, timeout: null }" x-init="@this.on('{{ $on }}', () => {
      clearTimeout(timeout);
      shown = true;
      timeout = setTimeout(() => { shown = false }, 2000);
  })" x-show.transition.out.opacity.duration.1500ms="shown"
  x-transition:leave.opacity.duration.1500ms {{ $attributes->merge(['class' => 'text-sm']) }}>
  {{ $slot->isEmpty() ? 'Saved.' : $slot }}
</div>
