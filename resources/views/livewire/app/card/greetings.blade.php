<div class="card">
  <div class="d-flex align-items-end row">
    <div class="col-sm-7">
      <div class="card-body">
        <h4 class="card-title text-primary">Welcome {{ $user->name }}! 😎</h4>
        <p class="mb-4">
        <blockquote><em>{{ $quote }}</em></blockquote>
        </p>
        <a class="btn btn-sm btn-outline-primary" href="{{ route('profile.index') }}">View profile</a>
      </div>
    </div>
    <div class="col-sm-5 text-sm-left text-center">
      <div class="card-body px-md-4 px-0 pb-0">
        <img data-app-dark-img="illustrations/man-with-laptop-dark.png"
          data-app-light-img="illustrations/man-with-laptop-light.png"
          src="build/assets/img/illustrations/man-with-laptop-light.png" alt="View Badge User" height="140" />
      </div>
    </div>
  </div>
</div>
