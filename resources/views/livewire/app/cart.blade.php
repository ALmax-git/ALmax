<div class="container-fluid px-4 pt-4">
  <div class="bg-secondary rounded p-4">
    <hr>
    @foreach ($cartItems as $cart)
      <div class="card text-bg-primary border-primary mb-2">
        <div class="card-header d-flex justify-content-between align-items-center" style="background-color: black;">
          <div class="card-title">{{ $cart->product->name }}</div>
          <div class="check">
            <input class="form-checkbox m-2" type="checkbox" wire:click="toggleSelectItem({{ $cart->id }})"
              {{ $cart->is_selected ? 'checked' : '' }}>
          </div>
        </div>
        <div class="card-body" style="background-color: black;">
          <div class="row">
            <div class="col-lg-4">
              {{ _app('Price') }}: {{ $cart->variant ? $cart->variant->sale_price : $cart->product->sale_price }} <br>
              {{ _app('Quantity') }}: {{ $cart->quantity }} <br>
              {{ _app('Total') }}:
              {{ ($cart->variant ? $cart->variant->sale_price : $cart->product->sale_price) * $cart->quantity }}
              <br>
              {{ _app('Status') }}: {{ $cart->status }} <br>
              {{ _app('Size') }}: {{ $cart->variant ? $cart->variant->size : $cart->product->size }} <br>
              {{ _app('color') }}: <span class="badge"
                style="height: 20px; width: 20px; background-color: {{ $cart->variant ? $cart->variant->color : $cart->product->color }}; color: {{ $cart->variant ? $cart->variant->color : $cart->product->color }};">
                O
              </span>
            </div>
            <div class="col-lg-4">
              @if ($cart->product->images()->count() > 0)
                @foreach ($cart->product->images() as $Image)
                  <img class="rounded-circle m-2" src="{{ 'storage/' . $Image->path }}"
                    alt="{{ $cart->product->name }}" style="height: 35px; width: 35px; object-fit: cover;">
                  {{-- wire:click='show_image("{{ $Image->path }}")' --}}
                @endforeach
              @endif
            </div>
            <div class="col-lg-4">
              <div class="row">
                <div class="col-12">
                  <div class="d-flex justify-content-between align-items-center float-end" style="width: min-content;">
                    <button class="btn btn-sm btn-outline-info ms-3" wire:click='decrement({{ $cart->id }})'><i
                        class="bi bi-dash"></i></button>
                    <button class="btn btn-sm btn-light ms-3"> {{ $cart->quantity }}</button>
                    <button class="btn btn-sm btn-outline-success ms-3" wire:click="increment({{ $cart->id }})"><i
                        class="bi bi-plus"></i></button>
                  </div>
                </div>
                <div class="col-12 mt-2">
                  <div class="d-flex justify-content-between align-items-center float-end" style="width: min-content;">
                    <button class="btn btn-sm btn-outline-info ms-2"
                      wire:click='open_view_product_modal("{{ $cart->product->id }}", "{{ $cart->variant_id }}")'><i
                        class="bi bi-eye"></i></button>
                    <button class="btn btn-sm btn-outline-danger ms-2"
                      wire:click='delete_cart_modal("{{ write($cart->id) }}")'><i class="bi bi-trash"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    {{ $cartItems->links() }}

    @if ($view_product_modal)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content bg-secondary">
            <div class="modal-header">
              <h5 class="modal-title">{{ $Product->name }}</h5>
              <button class="close" type="button" wire:click="close_view_product_modal">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              @livewire('component.card.productview', ['id' => $product_id, 'variant_id' => $variant_id])
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button"
                wire:click="close_view_product_modal">{{ _app('close') }}</button>
            </div>
          </div>
        </div>
      </div>
    @endif
    @if ($cart_delete_modal)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog">
          <div class="modal-content bg-secondary">
            <div class="modal-header">
              <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
              <button class="close" type="button" wire:click="close_delete_cart_modal">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ _app('msg_delete') }}?</p>
              <h3 class="text-primary text-center">{{ $cart->product->name }}</h3>
              {{-- <input class="form-control" type="password" wire:model.live="password"
                placeholder="Enter your password to confirm"> --}}
              @error($password)
                <span>{{ $message }}</span>
              @enderror
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button"
                wire:click="close_delete_cart_modal">{{ _app('cancel') }}</button>
              <button class="btn btn-danger" type="button" wire:click="confirm_delete_cart"><i
                  class="bi bi-trash"></i></button>
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>
</div>
