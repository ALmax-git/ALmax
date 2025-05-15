<div class="container-fluid m-auto px-4 pt-4">
  <div class="bg-secondary align-items-end row m-1 mt-2 rounded">
    <div class="col-sm-7">
      <div class="card-body">
        <h4 class="card-title text-primary">Welcome {{ $user->name }}! 😎</h4>
        <p class="mb-4">
        <blockquote><em>{{ $quote }}</em></blockquote>
        </p>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('app') }}">View profile</a>
      </div>
    </div>
    <div class="col-sm-5 text-sm-left text-center">
      <div class="card-body px-md-4 px-0 pb-0">
        <img data-app-dark-img="illustrations/man-with-laptop-dark.png"
          data-app-light-img="illustrations/man-with-laptop-light.png" src="{{ asset('images/man.png') }}"
          alt="View Badge User" height="140" />
      </div>
    </div>
  </div>
</div>
