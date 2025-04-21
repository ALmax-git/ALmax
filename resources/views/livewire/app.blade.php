<div class="container-fluid position-relative d-flex noselect p-0">
  <style>
    .form-control {
      background-color: #000 !important;
      color: #0800ff !important;
      border: 1px solid #0000f9 !important;
    }
  </style>
  <!-- Spinner Start -->
  {{-- <div
      class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center"
      id="spinner">
      <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="sr-only">Loading...</span>
      </div>
    </div> --}}
  <!-- Spinner End -->

  <!-- Sidebar Start -->
  <div class="sidebar pb-3 pe-4">
    <nav class="navbar bg-secondary navbar-dark">
      <a class="navbar-brand mx-4 mb-3" href="index.html">
        <h3 class="text-primary"><i class="fa bi-pen me-2"></i>ALmax</h3>
      </a>
      <div class="d-flex align-items-center pointer mb-4 ms-4" wire:click='toggle_profile_model'>
        <div class="position-relative">
          <img class="rounded-circle" src="{{ Auth::user()->client->logo() }}" alt=""
            style="width: 40px; height: 40px;">
          <div class="bg-success rounded-circle position-absolute bottom-0 end-0 border border-2 border-white p-1"
            wire:offline.class="bg-danger">
          </div>
        </div>
        <div class="ms-3">
          <h6 class="mb-0 text-right">{{ Auth::user()->client->name }}</h6>
          <span
            class="{{ Auth::user()->client->is_verified ? 'text-success' : 'text-warning' }}">{{ Auth::user()->client->is_verified ? _app('verified') : _app('unverified') }}</span>

        </div>
      </div>
      @if ($switch_profile)
        <div class="navbar-nav w-100">
          <hr>
          <style>
            .hover-client {
              border-left: 1px solid #4400ff;
            }

            .hover-client:hover {
              border-right: 2px solid #0400ff;
            }
          </style>
          @foreach (Auth::user()->clients as $client)
            <div class="d-flex align-items-center pointer hover-client mb-4 ms-4"
              wire:click='switch_profiles("{{ write($client->id) }}")'>
              <div class="position-relative">
                <img class="rounded-circle" src="{{ $client->logo() }}" alt=""
                  style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle position-absolute bottom-0 end-0 border border-2 border-white p-1"
                  wire:offline.class="bg-danger">
                </div>
              </div>
              <div class="ms-3">
                <h6 class="mb-0 text-right">{{ $client->name }}</h6>
                <span
                  class="{{ $client->is_verified ? 'text-success' : 'text-warning' }}">{{ $client->is_verified ? _app('verified') : _app('unverified') }}</span>
              </div>
            </div>
          @endforeach
          <span class="nav-item nav-link" wire:click='change_tab("New")'>
            <i class="fa bi-plus me-2"></i>{{ _app('create_new_business') }}
          </span>
        </div>
      @endif
      <div class="navbar-nav w-100">
        <hr>
        <a class="nav-item nav-link {{ $tab == 'Dashboard' ? 'active' : '' }}" href="{{ route('app') }}"
          wire:click='change_tab("Dashboard")'>
          <i class="fa bi-bar-chart me-2"></i>{{ _app('Dashboard') }}
        </a>
        @if (Auth::user()->id === 1)
          <span class="nav-item nav-link {{ $tab == 'System' ? 'active' : '' }}" wire:click='change_tab("System")'>
            <i class="fa fa-gears me-2"></i>{{ _app('System') }}
          </span>
        @endif

        <span class="nav-item nav-link {{ $tab == 'Profile' ? 'active' : '' }}" wire:click='change_tab("Profile")'>
          <i class="fa fa-user me-2"></i>{{ _app('Profile') }}
        </span>
        <span class="nav-item nav-link {{ $tab == 'Product' ? 'active' : '' }}" wire:click='change_tab("Product")'>
          <i class="fa bi-boxes me-2"></i>{{ _app('Product') }}
        </span>

        <span class="nav-item nav-link {{ $tab == 'Todo' ? 'active' : '' }}" wire:click='change_tab("Todo")'>
          <i class="fa bi-list-check me-2"></i>{{ _app('Todo') }}
        </span>

        <span class="nav-item nav-link" href="#" wire:click='closeApp'>
          <i class="fa fa-power-off me-2"></i>{{ _app('Exit') }}
        </span>
      </div>
    </nav>
  </div>
  <!-- Sidebar End -->

  <!-- Content Start -->
  <div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
      <a class="navbar-brand d-flex d-lg-none me-4" href="index.html">
        <h2 class="text-primary mb-0 text-right"><i class="bi bi-user-edit"></i></h2>
      </a>
      <a class="sidebar-toggler flex-shrink-0" href="#">
        <i class="fa fa-bars"></i>
      </a>
      <style>
        .clock {
          position: relative;
          background: rgba(116, 100, 100, 0);
          /* box-shadow: 0px 15px 25px rgba(0, 0, 0, 0.1); */
          z-index: 1000;
          border-radius: 10px;
          /* border: 1px solid rgba(255, 255, 255, 0.1); */
          backdrop-filter: blur(20px);
        }

        .clock .container {
          display: flex;
          justify-content: center;
          align-items: center;
          /* height: 100%; */
        }

        .clock .container h2 {
          font-size: 2em;
          color: #f3f3f3;
        }

        .clock .container h2:nth-child(odd) {
          padding: 5px;
          border-radius: 8px;
          background: rgba(255, 255, 255, 0.04);
          box-shadow: 0px 14px 24px rgba(0, 0, 0, 0);
          margin: 0 8px;
        }

        .clock .container h2#seconds {
          color: #0040ff;
        }

        .clock .container span {
          position: relative;
          top: -10px;
          font-size: 0.9em;
          color: #f3f3f3;
          font-weight: 700;
        }
      </style>
      <section>
        <div class="clock d-none d-md-block">
          <div class="container">
            <h2 id="hour">00</h2>
            <h2 class="dot">:</h2>
            <h2 id="minute">00</h2>
            <h2 class="dot">:</h2>
            <h2 id="seconds">00</h2>
            <span id="ampm">AM</span>
          </div>
        </div>
      </section>

      <!-- SCRIPT JAVASCRIPT -->
      <script type="text/javascript">
        function clock() {
          let hour = document.getElementById('hour');
          let minute = document.getElementById('minute');
          let seconds = document.getElementById('seconds');
          let ampm = document.getElementById('ampm');


          let h = new Date().getHours();
          let m = new Date().getMinutes();
          let s = new Date().getSeconds();
          var am = 'AM';

          if (h > 12) {
            h = h - 12;
            am = 'PM';
          }

          h = (h < 10) ? '0' + h : h;
          m = (m < 10) ? '0' + m : m;
          s = (s < 10) ? '0' + s : s;

          hour.innerHTML = h;
          minute.innerHTML = m;
          seconds.innerHTML = s;
          ampm.innerHTML = am;

        };

        var interval = setInterval(clock, 1000);
      </script>

      <div class="navbar-nav align-items-center ms-auto">
        {{-- --}}
        @livewire('component.switch-language')
        <div class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
            <img class="rounded-circle me-lg-2"
              src="{{ Auth::user()->profile_photo_path ? 'storage/' . Auth::user()->profile_photo_path : 'default.png' }}"
              alt="" style="width: 40px; height: 40px;">
            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-end bg-secondary rounded-0 rounded-bottom m-0 border-0">
            <a class="dropdown-item" href="#" wire:click='change_tab("Profile")'>{{ _app('Profile') }}</a>
            {{-- <a class="dropdown-item" href="#">Settings</a> --}}
            <a class="dropdown-item" href="#" wire:click='logout'>{{ _app('logout') }}</a>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar End -->

    @switch($tab)
      @case('Todo')
        <div class="container-fluid px-4 pt-4">
          @livewire('component.todo')
        </div>
      @break

      @case('New')
        @livewire('forms.create.client')
      @break

      @case('Profile')
        @livewire('component.profile')
      @break

      @case('Product')
        @livewire('app.clients.product')
      @break

      @case('System')
        @livewire('app.control')
      @break

      @default
        <!-- Sale & Revenue Start -->
        <div class="container-fluid px-4 pt-4">
          <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
              <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
                <i class="fa bi-people fa-3x text-primary"></i>
                <div class="ms-3">
                  <p class="mb-2">Users</p>
                  <h6 class="mb-0 text-right">{{ \App\Models\User::count() }}</h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
                <i class="fa bi-list-check fa-3x text-primary"></i>
                <div class="ms-3">
                  <p class="mb-2">Tasks</p>
                  <h6 class="mb-0 text-right">{{ Auth::user()->tasks->count() }}</h6>
                </div>
              </div>
            </div>
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
                <i class="fa bi-building fa-3x text-primary"></i>
                <div class="ms-3">
                  <p class="mb-2">{{ _app('Client') }}</p>
                  <h6 class="mb-0 text-right">{{ \App\Models\Client::count() }}</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container-fluid px-4 pt-4">
          @livewire('component.chart.server-request')
        </div>
    @endswitch
    <!-- Footer Start -->
    <div class="container-fluid px-4 pt-4">
      <div class="bg-secondary rounded-top mt-2 p-4">
        <div class="col-12 col-sm-6 text-sm-start text-center">
          <p>&copy; <strong>ALmax</strong>, {{ _app('copyright') }}.</p>
        </div>
      </div>
    </div>
    <!-- Footer End -->
  </div>
  <!-- Content End -->

  <!-- Back to Top -->
  <a class="btn btn-lg btn-primary btn-lg-square back-to-top" href="#"><i class="bi bi-arrow-up"></i></a>
</div>
