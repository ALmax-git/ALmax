<div class="container-fluid px-4 pt-4">
  <div class="bg-secondary rounded p-4">
    <!-- Search and Filters -->
    <div class="row mb-4">
      <div class="col-md-4 mb-2">
        <input class="form-control" type="text" wire:model.live.debounce.500ms="search" placeholder="Search products...">
      </div>

      <div class="col-md-3 mb-2">
        <select class="form-select" wire:model.live="category_id">
          <option value="">All Categories</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->title }}</option>
          @endforeach
        </select>
      </div>

      <div class="col-md-2 mb-2">
        <select class="form-select" wire:model.live="sort">
          <option value="latest">Latest</option>
          <option value="oldest">Oldest</option>
          <option value="low">Price: Low to High</option>
          <option value="high">Price: High to Low</option>
        </select>
      </div>

      <div class="col-md-3 d-flex align-items-center mb-2">
        <div class="form-check me-2">
          <input class="form-check-input" id="verifiedOnly" type="checkbox" wire:model.live="varified_only">
          <label class="form-check-label" for="verifiedOnly">
            Verified Sellers Only
          </label>
        </div>
      </div>
    </div>

    <!-- Products Grid -->
    <div class="row">
      @forelse($products as $product)
        <div class="col-md-4 mb-4">
          <div class="card h-100 bg-black shadow-sm">
            @if ($product->images()->count())
              @if ($product->images()->count() > 1)
                <div class="carousel slide" id="carouselExampleIndicators{{ $product->id }}" data-bs-ride="carousel">
                  <div class="carousel-inner">
                    @foreach ($product->images() as $key => $image)
                      <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                        <img class="d-block w-100" src="{{ 'storage/' . $image->path }}" alt="{{ $product->name }}"
                          style="height: 200px; object-fit: cover;">
                      </div>
                    @endforeach
                  </div>
                  <button class="carousel-control-prev" data-bs-target="#carouselExampleIndicators{{ $product->id }}"
                    data-bs-slide="prev" type="button">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" data-bs-target="#carouselExampleIndicators{{ $product->id }}"
                    data-bs-slide="next" type="button">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
                </div>
              @else
                <img class="card-img-top" src="{{ 'storage/' . $product->images()->first()->path }}"
                  alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
              @endif
              {{-- <img class="card-img-top" src="{{ $product->images()->first()->path }}" alt="{{ $product->name }}"
              style="height: 200px; object-fit: cover;"> --}}
            @else
              <div class="bg-secondary d-flex justify-content-center align-items-center" style="height: 200px;">
                <span class="text-muted">No Image</span>
              </div>
            @endif

            <div class="card-body d-flex flex-column bg-black" style="background-color: #000000 !important;">
              <h5 class="card-title"> {{ $product->client->country->flag }} {{ $product->name }}</h5>
              <p class="text-muted small mb-1">{{ $product->sub_title }}</p>
              <p class="flex-grow-1">{{ Str::limit($product->description, 80) }}</p>

              <div class="mt-2">
                @if ($product->discount > 0)
                  <span class="text-danger fw-bold">
                    {{ $product->discount }}% off
                  </span>
                  <strike><span class="badge bg-primary">{{ number_format($product->sale_price, 2) }}
                      {{ $product->client->country->currency }}</span></strike>
                  <span
                    class="badge bg-success">{{ number_format($product->sale_price - ($product->sale_price * $product->discount) / 100, 2) }}
                    {{ $product->client->country->currency }}</span>
                @else
                  <span class="badge bg-primary">{{ number_format($product->sale_price, 2) }}
                    {{ $product->client->country->currency }}</span>
                @endif
              </div>
            </div>

            <div class="card-footer border-top-0 d-flex justify-content-between align-items-center bg-secondary"
              style="background-color: #ffffff !important;">
              <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
              @if (optional($product->client)->varified)
                <span class="badge bg-success">Verified</span>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 mt-5 text-center">
          <h5 class="text-muted">No products found...</h5>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
      {{ $products->links() }}
    </div>
  </div>
</div>
