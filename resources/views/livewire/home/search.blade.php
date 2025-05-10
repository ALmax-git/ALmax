<div>
  <div class="nav-item d-flex align-items-center">
    <i class="bx bx-search fs-4 lh-0"></i>
    <input class="form-control border-0 shadow-none" type="text" aria-label="Search..." wire:model.live='search'
      wire:input='search_public' wire:focus='open_model' placeholder="Search..." />
  </div>

  <div class="modal fade show" id="search_ALmax" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="staticBackdropLabel" aria-hidden="true" tabindex="-1"
    style="display: {{ $search_model ? 'block' : 'hidden' }};" wire:outside.click='close_model'>
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button class="btn btn-sm btn-outline-success me-2">All</button>
          <button class="btn btn-sm btn-outline-success me-2">Products</button>
          <button class="btn btn-sm btn-outline-success me-2">Services</button>
          <button class="btn btn-sm btn-outline-success me-2">People you may know</button>
          <button class="btn-close" data-bs-dismiss="modal" type="button" aria-label="Close"
            wire:click='close_model'></button>
        </div>
        <div class="modal-body">
          <div class="nav-item d-flex align-items-center">
            <i class="bx bx-search fs-4 lh-0"></i>
            <input class="form-control border-1 shadow-none" type="text" aria-label="Search..."
              wire:model.live='search' wire:input='search_public' placeholder="Search..." />
          </div>
          @if (isset($people) && !empty($people))
            <div class="card">
              <div class="card-body">
                @foreach ($people as $person)
                  <div class="card mb-2">
                    <a class="btn" href="communities/{{ $person->email }}">
                      <div class="row">
                        <div class="col-3">
                          <img class="w-75 rounded-circle h-auto"
                            src="{{ $person->profile_photo_path ? asset('storage/' . $person->profile_photo_path) : asset('default.png') }}"
                            style="object-fit: cover;">
                        </div>
                        <div class="col-9">
                          <h5>{{ $person->name }}</h5>
                          <p>{!! $person->bio !!}</p>
                        </div>
                      </div>
                    </a>
                  </div>
                @endforeach
              </div>
            </div>
          @endif
          <hr>
          @if (isset($products) && !empty($product))
            <div class="card mb-2">
              <a class="btn" href="communities/{{ $product->name }}">
                <div class="row">
                  <div class="col-3">
                    {{-- <img class="w-75 rounded-circle h-auto"
                      src="{{ $person->profile_photo_path ? asset('storage/' . $person->profile_photo_path) : asset('default.png') }}"
                      style="object-fit: cover;"> --}}
                  </div>
                  <div class="col-9">
                    <h5>{{ $product->sub_title }}</h5>
                    <p>{{ $product->client->name }}</p>
                  </div>
                </div>
              </a>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>

</div>
