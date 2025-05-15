<div>
  @if ($sale_list_view)
    <div class="container-fluid px-4 pt-4">
      <div class="bg-secondary rounded-top mt-2 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="text-white">Sales</h2>
        </div>
        <div class="table-responsive">
          <div class="d-flex justify-content-between align-items-center rounded p-3" style="background-color: #000;">
            <div>
              <span class="text-white">Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of
                {{ $sales->total() }} entries</span>
            </div>
            <div>
              <span class="text-white">Total Sales: ₦{{ number_format($totalSales, 2) }}</span>
            </div>
            <div>
              <span class="text-white">Total Discount: ₦{{ number_format($totalDiscount, 2) }}</span>
            </div>
          </div>
          <table class="table-hover table bg-black" id="table-1">
            <thead class="table-black">
              <tr class="text-white">
                <th scope="col">#</th>
                <th scope="col">{{ _app('Product') }}</th>
                <th scope="col">{{ _app('Staff') }}</th>
                <th scope="col">{{ _app('quantity') }}</th>
                <th scope="col">{{ _app('Total') }}</th>
                <th scope="col">{{ _app('Discount') }}</th>
                <th scope="col">{{ _app('Actions') }}</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sales as $Sale)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $Sale->product->name }}</td>
                  <td>{{ $Sale->user->name }}</td>
                  <td>{{ (int) $Sale->quantity }}</td>
                  <td>{{ $Sale->total }}</td>
                  <td>{{ $Sale->discount }}</td>
                  <td>
                    <a class="btn btn-sm btn-primary"
                      wire:click='view_sale("{{ write($Sale->id) }}")'>{{ _app('Detail') }}</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          <div>
            {{ $sales->links() }}
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="buy-now mb-3">
    <button class="btn btn-lg btn-outline-primary btn-buy-now" type="button" wire:click='add_new_sale_modal'>
      Add New Sale
    </button>
  </div>
  @if ($detail_modal)
    <div class="modal d-block" tabindex="-1" style="display:block;">
      {{-- <div class="modal-backdrop fade show"></div> --}}
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">Sale Detail</h5>
            <button class="btn-close" type="button" wire:click="close_detail_modal"></button>
          </div>
          <div class="modal-body">
            <h4><strong>{{ _app('Product') }}:</strong> {{ $sale->product->name }} </h4>
            <h4><strong>{{ _app('Quantity') }}:</strong> {{ $sale->quantity }} </h4>
            <h4><strong>{{ _app('Unit Price') }}:</strong> {{ $sale->product->sale_price }} </h4>
            <h4><strong>{{ _app('Sub Total') }}:</strong> {{ $sale->product->sale_price * $sale->quantity }} </h4>
            <h4><strong>{{ _app('Discount') }}:</strong> {{ $sale->discount }} </h4>
            <h4><strong>{{ _app('Total') }}:</strong> {{ $sale->total - $sale->discount }} </h4>
            <hr>
            <h4><strong>{{ _app('Staff') }}:</strong> {{ $sale->user->name }} </h4>
            <h4><strong>{{ _app('Vendor') }}:</strong> {{ $sale->client->name }} </h4>

            <h4><strong>{{ _app('Date') }}:</strong> {{ $sale->created_at }} </h4>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" wire:click="close_detail_modal">{{ _app('close') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  <!-- Modal Dropdown -->
  @if ($showModal)
    <div class="modal d-block" tabindex="-1" style="display:block;">
      {{-- <div class="modal-backdrop fade show"></div> --}}
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">Add New Sale</h5>
            <button class="btn-close" type="button" wire:click="$set('showModal', false)"></button>
          </div>
          <div class="modal-body">

            <input class="form-control mb-2" type="text" placeholder="Search products..."
              wire:model.live.debounce.300ms="search">

            <div class="list-group mb-3" style="max-height: 200px; overflow-y: auto;">
              @foreach ($products as $product)
                <label class="list-group-item">
                  <input type="checkbox" wire:click="toggleProduct({{ $product->id }})"
                    {{ in_array($product->id, $selectedProducts) ? 'checked' : '' }}>
                  {{ $product->name }} - ₦{{ number_format($product->sale_price, 2) }}
                </label>
              @endforeach
            </div>

            @foreach ($selectedProducts as $productId)
              @php $product = $products->where('id', $productId)->first(); @endphp
              @if ($product)
                <div
                  class="bg-{{ $quantities[$productId] > $product->available_stock ? 'danger' : 'dark' }} mb-2 rounded border p-2">
                  <div class="d-flex justify-content-between align-items-center">
                    <div><strong>{{ $product->name }}</strong></div>
                    <div>
                      Quantity:
                      <input class="form-control d-inline-block w-auto" type="number"
                        wire:model.live="quantities.{{ $productId }}" min="1">
                      <span class="ms-2">=
                        ₦{{ number_format(($quantities[$productId] ?? 1) * $product->sale_price, 2) }}</span>
                    </div>
                  </div>
                </div>
              @endif
            @endforeach
            <div class="mb-2">
              <label class="form-label" for="discount">Discount</label>
              <input class="form-control" id="discount" type="number" wire:model.live="discount"
                placeholder="Enter discount amount">
            </div>
            <h2>Total: ₦{{ number_format($this->calculateTotal(), 2) }}</h2>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" wire:click="$set('showModal', false)">Cancel</button>
            <button class="btn btn-primary" wire:click="store">Save Sale</button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
