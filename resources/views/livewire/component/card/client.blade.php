<div class="card bg-dark mx-auto my-4 text-white shadow-lg"
  style="background: linear-gradient(135deg, #000000, #010633); border-radius: 1rem; max-width: 800px;">

  {{-- Header --}}
  <div class="card-header d-flex justify-content-between align-items-center border-0 pt-4">
    <div class="d-flex align-items-center">
      <i class="fa fa-user-circle fa-3x text-primary me-3"></i>
      <div>
        <h5 class="mb-0">{{ $client->owner->name }}</h5>
        <small class="text-white-50"><i class="fa bi-telephone me-2"></i>{{ $client->telephone }}</small>
        <br><small class="text-muted"><i class="fa bi-envelope me-2"></i>{{ $client->email }}</small>
      </div>
    </div>
    <div>
      <img class="rounded-circle border-3 border-primary border" src="{{ $client->logo() }}"
        alt="{{ $client->name }} Logo" style="width: 60px; height: 60px; object-fit: cover;">
    </div>
  </div>

  {{-- Body --}}
  <div class="card-body">
    <hr class="border-light mb-3 opacity-25">

    <div class="mb-3">
      <h6 class="text-uppercase text-secondary">Overview</h6>
      <p style="white-space: pre-wrap;">{!! $client->overview ?? '<i>No overview provided.</i>' !!}</p>
    </div>

    <div class="mb-3">
      <h6 class="text-uppercase text-secondary">Mission</h6>
      <p>{!! $client->mission ?? '<i>No mission defined.</i>' !!}</p>
    </div>

    <div class="mb-3">
      <h6 class="text-uppercase text-secondary">Vision</h6>
      <p>{!! $client->vision ?? '<i>No vision defined.</i>' !!}</p>
    </div>

    <div>
      <h6 class="text-uppercase text-secondary">Description</h6>
      <p>{!! $client->description ?? '<i>No description available.</i>' !!}</p>
    </div>
  </div>

  {{-- Footer --}}
  <div class="card-footer border-0 bg-transparent text-center">
    <span class="fw-bold fa-2x" style="font-weight: 800">{{ $client->name }} {!! $client->country->flag !!}</span>
    <br><span class="text-info mb-1">{{ $client->tagline }}</span>

    <div class="row g-4">
      <div class="col-md-3">
        <span class="d-block text-uppercase small text-muted">Country</span>
        <strong>{{ $client->country->name ?? '—' }}</strong>
      </div>
      <div class="col-md-3">
        <span class="d-block text-uppercase small text-muted">State</span>
        <strong>{{ $client->state->name ?? '—' }}</strong>
      </div>
      <div class="col-md-3">
        <span class="d-block text-uppercase small text-muted">City</span>
        <strong>{{ $client->city->name ?? '—' }}</strong>
      </div>
      <div class="col-md-3">
        <span class="d-block text-uppercase small text-muted">Category</span>
        <strong>{{ $client->category->title ?? '—' }}</strong>
      </div>
    </div>

    <hr class="my-4 opacity-25">

    <div class="d-flex justify-content-center gap-4">
      <span class="badge bg-{{ $client->is_registered ? 'success' : 'secondary' }}">
        {{ $client->is_registered ? 'Registered' : 'Not Registered' }}
      </span>
      <span class="badge bg-{{ $client->is_verified ? 'info' : 'secondary' }}">
        {{ $client->is_verified ? 'Verified' : 'Not Verified' }}
      </span>
      <span class="badge bg-{{ $client->status === 'active' ? 'primary' : 'warning' }}">
        {{ ucfirst($client->status) }}
      </span>
    </div>
  </div>
</div>
