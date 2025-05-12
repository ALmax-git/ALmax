<div class="container-fluid pt-4" style="min-height: 80vh;">
  <div class="h-100 bg-secondary p-3">
    <h2>{{ _app('Product') }}</h2>
    <div class="d-flex">
      <input class="form-control me-2" type="text" wire:model.live="search" placeholder="🔍 {{ _app('search') }}">

      @if (user_can_access('product_management'))
        <button class="btn btn-sm btn-primary me-2" wire:click='add_product_modal'>{{ _app('add') }}</button>
        <button class="btn btn-sm btn-outline-info me-2" wire:click='sync_all' wire:loading.attr="disabled">
          <i class="fa fa-refresh fa-spin" style="cursor: pointer;" wire:loading.class="text-dark"></i>
        </button>
      @endif
    </div>
  </div>
  @if (user_can_access('product_access'))
    <div class="table-responsive bg-secondary p-4">

      <table class="table-hover table bg-black" id="table-1">
        <thead class="table-black">
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
                <button class="btn btn-success" wire:click='view_product_modal("{{ write($Product->id) }}")'><i
                    class="bi bi-eye"></i></button>

                @if (user_can_access('product_management'))
                  <button class="btn btn-info" wire:click='edit_product_modal("{{ write($Product->id) }}")'><i
                      class="bi bi-pen"></i></button>
                  <button class="btn btn-outline-light" wire:click='open_label_model("{{ $Product->id }}")'><i
                      class="bi bi-qr-code fa2x"></i></button>
                  <button class="btn btn-danger" wire:click='delete_product_modal("{{ write($Product->id) }}")'><i
                      class="bi bi-trash"></i></button>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif
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
            <div class="row p-3" x-data="{ advance: false }">
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
              <div class="row" x-show="advance">
                <div class="col-lg-6 mb-2"><label class="form-label"
                    for="stock_price">{{ _app('stock_price') }}</label>
                  <input class="form-control" type="number" wire:model.live="stock_price"
                    placeholder="{{ _app('stock_price') }}">
                  @error('stock_price')
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
                <div class="col-lg-12 mb-2"><label class="form-label"
                    for="description">{{ _app('description') }}</label>
                  <textarea class="form-control"wire:model.live="description" placeholder="{{ _app('description') }}"></textarea>
                  @error('description')
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
                  <input class="form-control" type="text" wire:model.live="size"
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
                  <span class="form-label">{{ _app('Image') }}</span><br>
                  <label class="btn btn-primary mb-4 me-2" for="image" tabindex="0">
                    <i class="bi bi-upload"></i>
                    <input class="account-file-input" id="image" type="file" wire:model.live="image" multiple
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
                        <img class="rounded-circle m-1" src="{{ $Image->temporaryUrl() }}"
                          alt="Product Image Preview" style="width: 60px; height: 60px;">
                      @endforeach
                    </div>
                  @endif
                </div>
                @error('image')
                  <span class="error">{{ $message }}</span>
                @enderror

              </div>
              <a x-on:click="advance = !advance" wire:navigate>
                <span style="color:green" x-show="!advance"> More</span>
                <span style="color:orange" x-show="advance"> Less</span>
              </a>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('product_modal', false)">{{ _app('cancel') }}</button>
            @if ($is_edit)
              <button class="btn btn-primary" type="button" wire:click="update_product"><i
                  class="bi bi-pen"></i></button>
            @else
              <button class="btn btn-primary" type="button"
                wire:click="create_product">{{ _app('add') }}</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($product_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
            <button class="close" type="button" wire:click="$set('product_delete_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $product->name }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="$set('product_delete_modal', false)">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="confirm_delete_product"><i
                class="bi bi-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  @endif

  @if ($product_image_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
            <button class="close" type="button" wire:click="close_delete_product_image_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h3 class="text-primary text-center">{{ $product->name }}</h3>
            <hr>
            <p>{{ _app('msg_delete') }}</p>
            <img class="image" src="{{ 'storage/' . $image->path }}" alt=""
              style="width: 70px; height: 70px;">
            <hr>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_delete_product_image_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="confirm_delete_product_image"><i
                class="bi bi-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  @endif

  @if ($product_view_modal && !$label_model)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('Product') }}</h5>
            <button class="close" type="button" wire:click="$set('product_view_modal', false)">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p><strong>{{ _app('Name') }}:</strong> {{ $product->name }}</p>
            <p>{{ _app('Brand') }}:</strong> {{ $product->brand }}</p>
            <p>{{ _app('sub_title') }}:</strong> {{ $product->sub_title }}</p>
            <div style="display: flex; align-items: center; gap: 10px;">
              <hr style="flex: 1; margin: 0;">
              @if (user_can_access('product_management'))
                <button class="btn btn-sm btn-outline-primary" wire:click='open_product_images_modal'><i
                    class="bi bi-upload"></i></button>
                <button class="btn btn-sm btn-outline-light"
                  wire:click='open_label_model("{{ $product->id }}", {{ null }})'><i
                    class="bi bi-qr-code fa2x"></i></button>
              @endif
            </div>
            <div class="d-flex align-items-center pointer hover-client mb-4 ms-4" style="overflow-x: scroll;">
              @foreach ($product->images() as $image)
                <div class="position-relative m-2">
                  <img class="rounded-circle" src="{{ 'storage/' . $image->path }}" alt=""
                    style="width: 70px; height: 70px;">
                  <div class="rounded-circle position-absolute bottom-0 end-0 border-white" style="cursor: pointer;"
                    wire:click='delete_product_image_modal("{{ write($image->id) }}")'>
                    <i class="bi bi-trash" style="font-size: small; color: red;"></i>
                  </div>
                </div>
              @endforeach
            </div>
            <hr>
            <div class="d-flex" style="justify-content:  space-between;">
              <p><strong>{{ _app('variant') }}</strong></p>

              @if (user_can_access('product_management'))
                <button class="btn btn-sm btn-primary"
                  wire:click='open_add_variant_modal'>{{ _app('add') }}</button>
              @endif
            </div>
            <div class="table-responsive">

              <table class="table-hover table">
                <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th>{{ _app('label') }}</th>
                    <th>{{ _app('color') }}</th>
                    <th>{{ _app('size') }}</th>
                    <th>{{ _app('weight') }}</th>
                    <th>{{ _app('stock_price') }}</th>
                    <th>{{ _app('sale_price') }}</th>
                    <th>{{ _app('available_stock') }}</th>
                    <th>{{ _app('sold') }}</th>
                    {{-- <th>{{ _app('status') }}</th> --}}
                    <th>{{ _app('action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $count = 0;
                  @endphp
                  @foreach ($product->variants as $Variant)
                    <tr>
                      <td>{{ ++$count }}</td>
                      <td>{{ $Variant->label }}</td>
                      <td>
                        <div style="width: 15px; height: 15px; background-color: {{ $Variant->color }};"></div>
                      </td>
                      <td>{{ $Variant->size }}</td>
                      <td>{{ $Variant->weight }} {{ $Variant->si_unit }}</td>
                      <td>{{ $Variant->stock_price }}</td>
                      <td>{{ $Variant->sale_price }}</td>
                      <td>{{ $Variant->available_stock }}</td>
                      <td>{{ $Variant->sold ?? 0 }}</td>
                      {{-- <td>{{ $Variant->status }}</td> --}}
                      <td>
                        <button class="btn btn-info btn-sm"
                          wire:click="edit_variant_modal('{{ write($Variant->id) }}')"><i
                            class="bi bi-pencil"></i></button>
                        <button class="btn btn-danger btn-sm"
                          wire:click="delete_product_variant_modal('{{ write($Variant->id) }}')"><i
                            class="bi bi-trash"></i></button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <hr>
            <div class="d-flex" style="justify-content:  space-between;">
              <p><strong>{{ _app('Addons') }}</strong></p>

              @if (user_can_access('product_management'))
                <button class="btn btn-sm btn-primary"
                  wire:click='open_add_addons_modal'>{{ _app('add') }}</button>
              @endif
            </div>
            <div class="table-responsive">

              <table class="table-hover table">
                <thead class="table-dark">
                  <tr>
                    <th>#</th>
                    <th>{{ _app('label') }}</th>
                    <th>{{ _app('name') }}</th>
                    <th>{{ _app('brand') }}</th>
                    <th>{{ _app('Required') }}</th>
                    <th>{{ _app('Available') }}</th>
                    <th>{{ _app('Sale_price') }}</th>
                    <th>{{ _app('stock_price') }}</th>

                    <th>{{ _app('action') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $count = 0;
                  @endphp
                  @foreach ($product->addons as $Addon)
                    <tr>
                      <td>{{ ++$count }}</td>
                      <td>{{ $Addon->label }}</td>
                      <td>{{ $Addon->addonProduct->name }}</td>
                      <td>{{ $Addon->addonProduct->brand }}</td>
                      <td> <span
                          class="badge bg-{{ $Addon->required ? 'primary' : 'warning' }}">{{ $Addon->required ? 'Yes' : 'No' }}
                        </span></td>
                      <td>{{ $Addon->addonProduct->available_stock }}</td>
                      <td>{{ $Addon->addonProduct->sale_price }}</td>
                      <td>{{ $Addon->addonProduct->stock_price }}</td>
                      <td>
                        <button class="btn btn-info btn-sm"
                          wire:click="edit_product_addons_modal('{{ write($Addon->id) }}')"><i
                            class="bi bi-pencil"></i></button>
                        <button class="btn btn-danger btn-sm"
                          wire:click="delete_product_addons_modal('{{ write($Addon->id) }}')"><i
                            class="bi bi-trash"></i></button>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              <div class="table-responsive">

              </div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button"
                  wire:click="$set('product_view_modal', false)">{{ _app('close') }}</button>

              </div>
            </div>
          </div>
        </div>
  @endif
  @if ($label_model)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('Product') }}</h5>
            <button class="close" type="button" wire:click="close_label_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <style>
              .label-card {
                width: 300px;
                /* Adjust as needed */
                border: 1px solid #343a40;
                /* Dark border to blend with background */
                border-radius: 8px;
              }

              .store-logo {
                max-width: 50px;
                /* Adjust logo size */
                height: auto;
              }

              .store-name {
                font-size: 1.1rem;
              }

              .product-name {
                font-size: 1.3rem;
                letter-spacing: 0.5px;
                color: #000000 !important;
              }

              .price {
                font-size: 1.2rem;
              }

              .qr-code {
                max-width: 60px;
                /* Adjust QR code size */
                height: auto;
              }
            </style>
            <h1>{{ $product->name }}</h1>
            <div class="d-flex flex-wrap gap-4" style="justify-content: center;">
              @foreach ($product->labels as $label)
                <div class="card text-dark label-card bg-white">
                  <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                      <img class="store-logo rounded-circle me-3" src="{{ Auth::user()->client->logo() }}"
                        alt="Store Logo">
                      <h6 class="card-title store-name text-info mb-0">{{ Auth::user()->client->name }}</h6>
                    </div>
                    <h5 class="card-subtitle product-name fw-bold mb-2">{{ $product->name }}
                    </h5>
                    @if ($label->variant)
                      <span class="badge" style=" background-color: {{ $label->variant->color }};">
                        {{ $label->variant->size }}</span>
                    @endif # {{ $loop->iteration }}
                    <div class="d-flex justify-content-between align-items-center">
                      <p class="card-text price text-success">{{ Auth::user()->client->country->currency }}
                        {{ $product->sale_price }}</p>
                      <img class="qr-code" src="{{ $qrCodes[$label->id] }}" alt="QR Code">
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_label_modal">{{ _app('close') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($product_variant_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            @if ($is_edit)
              <h5 class="modal-title">{{ _app('edit_product_variant') }}</h5>
              <h4 class="text-center">{{ $product->name }}</h4>
            @else
              <h5 class="modal-title">{{ _app('add_product_variant') }}</h5>
            @endif
            <button class="close" type="button" wire:click="close_add_variant_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row p-3">
              <div class="col-lg-12 mb-2"><label class="form-label" for="label">{{ _app('label') }}</label>
                <input class="form-control" type="text" wire:model.live="label"
                  placeholder="{{ _app('label') }}">
                @error('label')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label" for="size">{{ _app('size') }}</label>
                <input class="form-control" type="text" wire:model.live="size"
                  placeholder="{{ _app('size') }}">
                @error('size')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label" for="color">{{ _app('color') }}</label>
                <input class="form-control" type="color" wire:model.live="color"
                  placeholder="{{ _app('color') }}">
                @error('color')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label" for="si_unit">{{ _app('si_unit') }}</label>
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
              <div class="col-lg-6 mb-2"><label class="form-label" for="weight">{{ _app('weight') }}</label>
                <input class="form-control" type="number" wire:model.live="weight"
                  placeholder="{{ _app('weight') }}">
                @error('weight')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label"
                  for="stock_price">{{ _app('stock_price') }}</label>
                <input class="form-control" type="number" wire:model.live="stock_price"
                  placeholder="{{ _app('stock_price') }}">
                @error('stock_price')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
              <div class="col-lg-6 mb-2"><label class="form-label"
                  for="sale_price">{{ _app('sale_price') }}</label>
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
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_add_variant_modal">{{ _app('cancel') }}</button>
            @if ($is_edit)
              <button class="btn btn-primary" type="button" wire:click="update_product_variant"><i
                  class="bi bi-pen"></i></button>
            @else
              <button class="btn btn-primary" type="button"
                wire:click="create_product_variant">{{ _app('add') }}</button>
            @endif

          </div>
        </div>
      </div>
    </div>

  @endif
  @if ($product_variant_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
            <button class="close" type="button" wire:click="close_delete_product_variant_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $product->name }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_delete_product_variant_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="confirm_delete_product_variant"><i
                class="bi bi-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($product_addons_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('add_product_addons') }}</h5>
            <button class="close" type="button" wire:click="close_add_product_addons_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('add_addons') }}?</p>
            <h4 class="text-primary">{{ $product->name }}</h4>

            <div class="col-lg-12 mb-2"><label class="form-label" for="label">{{ _app('label') }}</label>
              <input class="form-control" type="text" wire:model.live="label"
                placeholder="{{ _app('label') }}">
              @error('label')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-lg-12 mb-2"><label class="form-label"
                for="addon_product_id">{{ _app('Addons') }}</label>
              <select class="form-control" wire:model.live="addon_product_id">
                <option value="">{{ _app('choose') }}</option>
                @foreach ($products as $Product)
                  @if ($Product->id !== $product->id)
                    <option value="{{ $Product->id }}">{{ $Product->name }} <strong>-</strong>
                      {{ $Product->brand }}</option>
                  @endif
                @endforeach
              </select>
              @error('addon_product_id')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-lg-12 mb-2">
              <label class="form-label" for="required">{{ _app('required') }}</label>
              <div class="form-check form-switch">
                <input class="form-check-input" id="required" type="checkbox" wire:model.live="required">
                <label class="form-check-label" for="required">{{ _app('yes') }}</label>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_add_product_addons_modal">{{ _app('cancel') }}</button>
            @if ($is_edit)
              <button class="btn btn-primary" type="button" wire:click="update_product_addons"><i
                  class="bi bi-pen"></i></button>
            @else
              <button class="btn btn-primary" type="button"
                wire:click="create_product_addons">{{ _app('add') }}</button>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($product_addons_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
            <button class="close" type="button" wire:click="close_delete_product_addons_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $product->name }} <strong>-</strong> {{ $addon->label }} </h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_delete_product_addons_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="confirm_delete_product_addons"><i
                class="bi bi-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($product_image_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('Product') }}</h5>
            <button class="close" type="button" wire:click="close_product_images_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h1>{{ $product->name }}</h1>
            <input class="form-control" type="file" wire:model.live="image" multiple
              placeholder="{{ _app('Image') }}">
            @error('image')
              <span class="text-danger">{{ $message }}</span>
            @enderror
            <hr>
            @if ($image)
              <div class="row">
                @foreach ($image as $Image)
                  <img class="rounded-circle m-1" src="{{ $Image->temporaryUrl() }}" alt="Product Image Preview"
                    style="width: 60px; height: 60px;">
                @endforeach
              </div>
            @endif
            <hr>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_product_images_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-primary" type="button"
              wire:click='upload_product_image'>{{ _app('upload') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
