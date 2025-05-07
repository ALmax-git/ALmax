<div class="container-fluid p-4">
  <div class="bg-secondary h-100 rounded p-4">
    <h6 class="mb-4">{{ _app('system') }}/{{ _app($tab) }}</h6>
    <nav>
      <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <button class="nav-link {{ $tab == 'Clients' ? 'active' : '' }}" id="nav-home-tab" data-bs-toggle="tab"
          data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true"
          wire:click='toggle_c_tab("Clients")'>{{ _app('Client') }}</button>
        <button class="nav-link {{ $tab == 'Geolocation' ? 'active' : '' }}" id="nav-geolocation-tab"
          data-bs-toggle="tab" data-bs-target="#nav-geolocation" type="button" role="tab"
          aria-controls="nav-geolocation" aria-selected="true"
          wire:click='toggle_c_tab("Geolocation")'>{{ _app('Geolocation') }}</button>
        <button class="nav-link {{ $tab == 'Product' ? 'active' : '' }}" id="nav-Product-tab" data-bs-toggle="tab"
          data-bs-target="#nav-Product" type="button" role="tab" aria-controls="nav-Product" aria-selected="true"
          wire:click='toggle_c_tab("Product")'>{{ _app('Product') }}</button>
        <button class="nav-link {{ $tab == 'Business' ? 'active' : '' }}" id="nav-Business-tab" data-bs-toggle="tab"
          data-bs-target="#nav-Business" type="button" role="tab" aria-controls="nav-Business" aria-selected="true"
          wire:click='toggle_c_tab("Business")'>{{ _app('Business') }}</button>
        <button class="nav-link {{ $tab == 'Role And Permission' ? 'active' : '' }}" id="nav-Role-And-Permission-tab"
          data-bs-toggle="tab" data-bs-target="#nav-Role And Permission" type="button" role="tab"
          aria-controls="nav-Role-And-Permission" aria-selected="true"
          wire:click='toggle_c_tab("Role And Permission")'>{{ _app('Role And Permission') }}</button>
      </div>
    </nav>
    <div class="tab-content pt-3" id="nav-tabContent">
      <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
        @switch($tab)
          @case('Clients')
            @livewire('app.clients.index')
          @break

          @case('Geolocation')
            @livewire('app.clients.geoloacations')
          @break

          @case('Product')
            @livewire('app.clients.product-settings')
          @break

          @case('Business')
            @livewire('app.clients.business')
          @break

          @case('Role And Permission')
            @livewire('app.clients.role-and-permission')
          @break

          @default
        @endswitch
      </div>
    </div>
  </div>
</div>
