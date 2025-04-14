<div class="container-fluid pt-4" style="min-height: 80vh;">
  <div class="h-100 bg-secondary rounded p-4">
    <h2>{{ _app('Product') }}</h2>
    <div class="d-flex mb-4">
      <input class="form-control me-2" type="text" wire:model.live="search" placeholder="{{ _app('search') }}">

      <button class="btn btn-sm btn-primary" wire:click='add_product_modal'>{{ _app('add') }}</button>
    </div>
  </div>
  <table class="mt-4 table">
    <thead>
      <tr>
        <th>{{ _app('name') }}</th>
        <th>{{ _app('brand') }}</th>
        <th>{{ _app('category') }}</th>
        <th>{{ _app('stock_price') }}</th>
        <th>{{ _app('sale_price') }}</th>
        <th>{{ _app('discount') }}</th>
        <th>{{ _app('available_stock') }}</th>
        <th>{{ _app('sold') }}</th>
        <th>{{ _app('status') }}</th>
        <th>{{ _app('action') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($products as $Product)
        <tr>
          <td>{{ $Product->name }}</td>
          <td>{{ $Product->brand }}</td>
          <td>{{ $Product->category->title }}</td>
          <td>{{ $Product->stock_price }}</td>
          <td>{{ $Product->sale_price }}</td>
          <td>{{ $Product->discount }}</td>
          <td>{{ $Product->available_stock }}</td>
          <td>{{ $Product->sold }}</td>
          <td>{{ $Product->status }}</td>
          <td>
            <button class="btn btn-info"
              wire:click='edit_product_category_modal("{{ write($Product->id) }}")'>{{ _app('update') }}</button>
            <button class="btn btn-danger"
              wire:click='delete_product_category("{{ write($Product->id) }}")'>{{ _app('Delete') }}</button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @if ($product_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('create_product') }}</h5>
            <button class="close" type="button" wire:click="$set('product_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body" style="height: 50vh; overflow-y: scroll;">
            <div class="row p-3">
              <div class="col-lg-6 mb-2">
                <label class="form-label" for="name">{{ _app('name') }}</label>
                <input class="form-control" type="text" wire:model.live="name" placeholder="{{ _app('name') }}">
                @error('name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label" for="brand">{{ _app('brand') }}</label>
                <input class="form-control" type="text" wire:model.live="brand" placeholder="{{ _app('brand') }}">
                @error('brand')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-12 mb-2"><label class="form-label" for="sub_title">{{ _app('sub_title') }}</label>
                <input class="form-control" type="text" wire:model.live="sub_title"
                  placeholder="{{ _app('sub_title') }}">
                @error('sub_title')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-12 mb-2"><label class="form-label" for="category_id">{{ _app('category') }}</label>
                <select class="form-control" wire:model.live="category_id">
                  <option value="">{{ _app('choose') }}</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                  @endforeach
                </select>
                @error('category_id')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-12 mb-2"><label class="form-label" for="description">{{ _app('description') }}</label>
                <textarea class="form-control"wire:model.live="description" placeholder="{{ _app('description') }}"></textarea>
                @error('description')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label" for="stock_price">{{ _app('stock_price') }}</label>
                <input class="form-control" type="number" wire:model.live="stock_price"
                  placeholder="{{ _app('stock_price') }}">
                @error('stock_price')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label" for="sale_price">{{ _app('sale_price') }}</label>
                <input class="form-control" type="number" wire:model.live="sale_price"
                  placeholder="{{ _app('sale_price') }}">
                @error('sale_price')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label"
                  for="available_stock">{{ _app('available_stock') }}</label>
                <input class="form-control" type="number" wire:model.live="available_stock"
                  placeholder="{{ _app('available_stock') }}">
                @error('available_stock')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label" for="discount">{{ _app('discount') }}</label>
                <input class="form-control" type="number" wire:model.live="discount"
                  placeholder="{{ _app('discount') }}">
                @error('discount')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-2 mb-2"><label class="form-label" for="color">{{ _app('color') }}</label>
                <input class="form-control" type="color" wire:model.live="color"
                  placeholder="{{ _app('color') }}">
                @error('color')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-4 mb-2"><label class="form-label" for="size">{{ _app('size') }}</label>
                <input class="form-control" type="number" wire:model.live="size"
                  placeholder="{{ _app('size') }}">
                @error('size')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-3 mb-2"><label class="form-label" for="si_unit">{{ _app('si_unit') }}</label>
                <select class="form-control" wire:model.live="si_unit">
                  <option value="">{{ _app('si_unit') }}</option>
                  @foreach (system_si_unit() as $unit)
                    <option value="{{ $unit['symbol'] }}">{{ $unit['title'] }}</option>
                  @endforeach
                </select>
                @error('si_unit')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-3 mb-2"><label class="form-label" for="weight">{{ _app('weight') }}</label>
                <input class="form-control" type="number" wire:model.live="weight"
                  placeholder="{{ _app('weight') }}">
                @error('weight')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="button-wrapper mb-3">
                @error('photo')
                  <span class="error">{{ $message }}</span>
                @enderror
                <span class="form-label">{{ _app('Image') }}</span><br>
                <label class="btn btn-primary mb-4 me-2" for="image" tabindex="0">
                  <i class="bi bi-upload"></i>
                  <input class="account-file-input" id="image" type="file" wire:model="image" hidden multiple
                    accept="image/png, image/jpeg" />
                </label>

                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"
                  wire:loading wire:target="image">
                  <span class="sr-only">Loading...</span>
                </div>
                <!-- Preview Section -->
                @if ($image)
                  <div class="row">
                    @foreach ($image as $Image)
                      <img class="rounded-circle m-1" src="{{ $Image->temporaryUrl() }}" alt="Product Image Preview"
                        style="width: 60px; height: 60px;">
                    @endforeach
                  </div>
                @endif
              </div>

            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('product_modal', false)">{{ _app('cancel') }}</button>
            <button class="btn btn-primary" type="button" wire:click="create_product">{{ _app('add') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
