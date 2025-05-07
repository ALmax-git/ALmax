<div class="container-fluid px-4 pt-4">
  <div class="bg-secondary rounded">
    <h3>{{ $product->client->name }} {{ $product->client->country->flag }}</h3>
    <hr>
    <h5>{{ $product->name }}</h5>
    <div class="row">
      <div class="col-md-6">
        <div class="row">
          <div class="col-12">
            <img class="img-fluid" src="{{ 'storage/' . $image_path }}" alt="{{ $product->name }}"
              style="height: 250px; width: 250px; object-fit: cover;">
          </div>
          <div class="col-12">
            @foreach ($product->images() as $Image)
              <img class="rounded-circle m-2" src="{{ 'storage/' . $Image->path }}" alt="{{ $product->name }}"
                style="height: 35px; width: 35px; object-fit: cover;" wire:click='show_image("{{ $Image->path }}")'>
            @endforeach
          </div>
          <div class="col-12">
            <p>{{ $product->description }}</p>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <p class="text-muted small mb-1">{{ $product->sub_title }}</p>

        <div class="mt-2">
          <h3>
            @if ($variant)
              Size: {{ $variant->size }} <br>
              Color : <span class="badge"
                style="height: 20px; width: 20px; background-color: {{ $variant->color }}; color: {{ $variant->color }};">
                O
              </span> <br>
              Price:
              @if ($product->discount > 0)
                <span class="text-danger fw-bold">
                  {{ $product->discount }}% off
                </span>
                <strike><span class="badge bg-primary">{{ number_format($product->sale_price, 2) }}
                    {{ $product->client->country->currency }}</span></strike>
                <span
                  class="badge bg-success">{{ number_format($variant->sale_price - ($variant->sale_price * $product->discount) / 100, 2) }}
                  {{ $product->client->country->currency }}</span>
              @else
                <span class="badge bg-primary">{{ number_format($variant->sale_price, 2) }}
                  {{ $product->client->country->currency }}</span>
              @endif
            @else
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
            @endif
          </h3>
        </div>
        <div class="row mt-2">
          <div class="col-12 d-flex mb-2 flex-wrap gap-2">
            @foreach ($product->variants as $Variant)
              <button class="btn {{ $variant_id == $Variant->id ? 'btn-dark' : '' }}"
                style="background-color: {{ $Variant->color }};"
                wire:click='select_variant("{{ write($Variant->id ?? 0) }}")'>
                {{ $Variant->size }}
                @if (isset($cart[$Variant->id]))
                  <span class="badge bg-light text-dark ms-1">{{ $cart[$Variant->id] }}</span>
                @endif
              </button>
            @endforeach
          </div>

          <div class="col-12">
            {{-- @if ($variant_id) --}}
            <button class="btn btn-primary"
              wire:click="add_to_cart('{{ write($product->id) }}', '{{ write($variant_id) ?? 0 }}')">
              <i class="bi bi-cart"></i> Add to Cart
            </button>
            {{-- @else
              <button class="btn btn-secondary" disabled>
                <i class="bi bi-cart"></i> Select a Variant First
              </button>
            @endif --}}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
