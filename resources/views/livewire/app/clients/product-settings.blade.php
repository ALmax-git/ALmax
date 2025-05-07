<div class="container-fluid">
  <div class="card bg-black p-2" style="background-color: black;">
    <div class="row g-4 bg-black">
      <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
          <i class="fa bi-boxes fa-3x text-primary"></i>
          <div class="ms-3">
            <p class="mb-2">{{ _app('Products') }}</p>
            <h6 class="mb-0 text-right">{{ \App\Models\Product::count() }}</h6>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
          <i class="fa bi-boxes fa-3x text-success"></i>
          <div class="ms-3">
            <p class="mb-2">{{ _app('available_products') }}</p>
            <h6 class="mb-0 text-right">{{ \App\Models\Product::where('available_stock', '>=', 1)->count() }}</h6>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
          <i class="fa bi-list fa-3x text-primary"></i>
          <div class="ms-3">
            <p class="mb-2">{{ _app('categories') }}</p>
            <h6 class="mb-0 text-right">{{ \App\Models\ProductCategory::count() }}</h6>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-xl-3">
        <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
          <i class="fa bi-building fa-3x text-primary"></i>
          <div class="ms-3">
            <p class="mb-2">{{ _app('Client') }}</p>
            <h6 class="mb-0 text-right">{{ \App\Models\Client::count() }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr>
  <div class="h-100 bg-secondary rounded">
    <div class="d-flex mb-4">
      <input class="form-control me-2" type="text" wire:model.live="search" placeholder=" 🔍 {{ _app('search') }}">

      <button class="btn btn-sm btn-primary" wire:click='add_product_category_modal'>{{ _app('add') }}</button>
    </div>
  </div>
  <table class="table-striped table-hover table-sm table">
    <thead class="table-dark">
      <tr>
        <th>{{ _app('Category') }}</th>
        <th>{{ _app('Status') }}</th>
        <th>{{ _app('Products') }}</th>
        <th>{{ _app('action') }}</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $category)
        <tr>
          <td>{{ $category->title }}</td>
          <td>{{ $category->status }}</td>
          <td>{{ $category->products->count() }}</td>
          <td>
            <button class="btn btn-info" wire:click='edit_product_category_modal("{{ write($category->id) }}")'><i
                class="bi bi-pen"></i></button>
            <button class="btn btn-danger" wire:click='delete_product_category("{{ write($category->id) }}")'><i
                class="bi bi-trash"></i></button>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $categories->links() }}
  @if ($product_category_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('create_product') }}</h5>
            <button class="close" type="button" wire:click="$set('product_category_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body scrollable scroll">
            <label class="form-label" for="title">{{ _app('title') }}</label>
            <input class="form-control" type="text" wire:model.live="title" placeholder="{{ _app('title') }}">
            @error('title')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <label class="form-label" for="status">{{ _app('status') }}</label>
            <select class="form-control" id="status" name="status" wire:model.live='status'>
              <option value="">{{ _app('choose') }}</option>
              <option value="active">{{ _app('active') }}</option>
              {{-- <option value="discontinued">{{ _app('discontinued') }}</option> --}}
              <option value="archived">{{ _app('archived') }}</option>
            </select>
            @error($status)
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('product_category_modal', false)">{{ _app('cancel') }}</button>
            @if ($is_edit)
              <button class="btn btn-primary" type="button" wire:click="update_product_category"><i
                  class="bi bi-pen"></i></button>
            @else
              <button class="btn btn-primary" type="button"
                wire:click="create_product_category">{{ _app('add') }}</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
  <!-- Delete Confirmation Modal -->
  @if ($product_category_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
            <button class="close" type="button" wire:click="$set('product_category_delete_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $product_category->title }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('product_category_delete_modal', false)">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="confirm_delete_product_category"><i
                class="bi bi-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
