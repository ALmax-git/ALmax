<div class="container-fluid position-relative d-flex noselect p-0">
  <style>
    .form-control {
      background-color: #000 !important;
      color: #0800ff !important;
      border: 1px solid #0000f9 !important;
    }

    .card {
      transition: transform 0.3s ease-in-out;
    }

    .card:hover {
      transform: scale(1.01);
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
      <a class="navbar-brand mx-4 mb-3" href="/">
        <h3 class="text-primary"><i class="fa bi-boxes me-2"></i>ALmax</h3>
      </a>
      <div class="d-flex align-items-center mb-4 ms-4" style="cursor: pointer;" wire:click='toggle_profile_model'>
        <div class="position-relative">
          <img class="rounded-circle" src="{{ Auth::user()->client->logo() }}" alt=""
            style="width: 40px; height: 40px;" loading="lazy">
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

            .close {
              position: relative;
              width: 4em;
              height: 4em;
              border: none;
              background: rgba(180, 83, 107, 0.11);
              border-radius: 5px;
              transition: background 0.5s;
            }

            .close:hover {
              background-color: rgb(211, 21, 21);
            }

            .close:active {
              background-color: rgb(130, 0, 0);
            }

            .close:hover>.close {
              animation: close 0.2s forwards 0.25s;
            }

            @keyframes close {
              100% {
                opacity: 1;
              }
            }
          </style>
          @foreach (Auth::user()->clients as $client)
            <div class="d-flex align-items-center hover-client style= mb-4 ms-4" style="cursor: pointer;"
              wire:click='switch_profiles("{{ write($client->id) }}")'>
              <div class="position-relative">
                <img class="rounded-circle" src="{{ $client->logo() }}" alt=""
                  style="width: 40px; height: 40px;" loading="lazy">
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
          <span class="nav-item nav-link" style="cursor: pointer;" wire:click='change_tab("New")'>
            <i class="fa bi-plus me-2"></i>{{ _app('create_new_business') }}
          </span>
        </div>
      @endif
      <div class="navbar-nav w-100">
        <hr>

        {{-- General --}}
        <a class="nav-item nav-link {{ $tab == 'Dashboard' ? 'active' : '' }}" href="{{ route('app') }}"
          style="cursor: pointer;" wire:click='change_tab("Dashboard")'>
          <i class="fa bi-bar-chart me-2"></i>{{ _app('Dashboard') }}
        </a>

        <span class="nav-item nav-link {{ $tab == 'Profile' ? 'active' : '' }}" style="cursor: pointer;"
          wire:click='change_tab("Profile")'>
          <i class="fa fa-user me-2"></i>{{ _app('Profile') }}
        </span>

        {{-- Business Tools --}}
        @if (user_can_access('business_access'))
          <span class="nav-item nav-link {{ $tab == 'Business' ? 'active' : '' }}" style="cursor: pointer;"
            wire:click='change_tab("Business")'>
            <i class="fa bi-briefcase me-2"></i>{{ _app('Business') }}
          </span>
        @endif
        @if (user_can_access('product_access'))
          <span class="nav-item nav-link {{ $tab == 'Product' ? 'active' : '' }}" style="cursor: pointer;"
            wire:click='change_tab("Product")'>
            <i class="fa bi-boxes me-2"></i>{{ _app('Product') }}
          </span>
        @endif

        <span class="nav-item nav-link {{ $tab == 'Todo' ? 'active' : '' }}" style="cursor: pointer;"
          wire:click='change_tab("Todo")'>
          <i class="fa bi-list-check me-2"></i>{{ _app('Todo') }}
        </span>

        {{-- Market and Social --}}
        <span class="nav-item nav-link {{ $tab == 'Market' ? 'active' : '' }}" style="cursor: pointer;"
          wire:click='change_tab("Market")'>
          <i class="fa bi-shop me-2"></i>{{ _app('Market') }}
        </span>

        <span class="nav-item nav-link {{ $tab == 'Cart' ? 'active' : '' }}" style="cursor: pointer;"
          wire:click='change_tab("Cart")'>
          <i class="fa bi-cart position-relative me-2">
            <span class="position-absolute start-100 translate-middle badge rounded-pill bg-primary top-0">
              {{ Auth::user()->cart_items->count() }}
              <span class="visually-hidden">Cart</span>
            </span></i>{{ _app('Cart') }}
        </span>

        <span class="nav-item nav-link {{ $tab == 'Community' ? 'active' : '' }}" style="cursor: pointer;"
          wire:click='change_tab("Community")'>
          <i class="fa bi-people-fill me-2"></i>{{ _app('Community') }}
        </span>

        {{-- Finance --}}
        <span class="nav-item nav-link {{ $tab == 'Wallet' ? 'active' : '' }}" style="cursor: pointer;"
          wire:click='change_tab("Wallet")'>
          <i class="fa bi-wallet2 me-2"></i>{{ _app('Wallet') }}
        </span>

        @if (user_can_access('event_access'))
          <span class="nav-item nav-link {{ $tab == 'Event' ? 'active' : '' }}" style="cursor: pointer;"
            wire:click='change_tab("Event")'>
            <i class="fa bi-calendar-event me-2"></i>{{ _app('Event') }}
          </span>
        @endif

        {{-- Admin & System --}}
        @if (Auth::user()->id === 1)
          <span class="nav-item nav-link {{ $tab == 'System' ? 'active' : '' }}" style="cursor: pointer;"
            wire:click='change_tab("System")'>
            <i class="fa fa-gears me-2"></i>{{ _app('System') }}
          </span>
        @endif
        @if (user_can_access('business_settings'))
          <span class="nav-item nav-link {{ $tab == 'Settings' ? 'active' : '' }}" style="cursor: pointer;"
            wire:click='change_tab("Settings")'>
            <i class="fa bi-shield me-2"></i>{{ _app('Management') }}
          </span>
        @endif

        <a class="nav-item nav-link {{ $tab == 'Support' ? 'active' : '' }}" href="mailto:abituho7s@mozmail.com"
          style="cursor:help;">
          <i class="fa bi-headset me-2"></i>{{ _app('Support') }}
          {{-- wire:click='change_tab("Support")' --}}
        </a>

        {{-- Exit --}}
        <span class="nav-item nav-link" style="cursor: pointer;" wire:click='logout'>
          <i class="fa fa-power-off me-2"></i>{{ _app('logout') }}
        </span>
      </div>

    </nav>
  </div>
  <!-- Sidebar End -->

  <!-- Content Start -->
  <div class="content">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
      <a class="navbar-brand d-flex d-lg-none me-4" href="/">
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
        <div class="clock d-none d-md-block" style="cursor:not-allowed;">
          <div class="container" x-init="setInterval(() => {
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
              {{-- if (s == 59) {
                  if ($wire.tab == 'Dashboard') {
                      $wire.reload();
                  } else {
                      $wire.refresh();
                  }
              } --}}
              hour.innerHTML = h;
              minute.innerHTML = m;
              seconds.innerHTML = s;
              ampm.innerHTML = am;
          }, 1000);">
            <h2 id="hour">--</h2>
            <h2 class="dot">:</h2>
            <h2 id="minute">--</h2>
            <h2 class="dot">:</h2>
            <h2 id="seconds">--</h2>
            <span id="ampm">--</span>
          </div>
        </div>
      </section>

      <div class="navbar-nav align-items-center m-auto" style="cursor:wait;" wire:loading>
        @livewire('app.loading')
      </div>
      <div class="navbar-nav align-items-center ms-auto">
        @if (Auth::user()->event_tickets->count() > 0)
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
              <i class="fa fa-bell"></i>
              <span class="position-absolute start-100 translate-middle badge rounded-pill bg-primary top-0">
                {{ Auth::user()->event_tickets->count() }}
                <span class="visually-hidden">New alerts</span>
              </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary rounded-0 rounded-bottom m-0 border-0"
              style="color: white;">
              @foreach (Auth::user()->event_tickets as $ticket)
                <a class="dropdown-item p-3" href="#" style="color: white;"
                  wire:click='view_ticket("{{ write($ticket->id) }}")'>{{ $ticket->event->title }}</a>
              @endforeach
              <a class="dropdown-item p-3" href="#"
                wire:click='change_tab("Event")'>{{ _app('View_All') }}</a>
            </div>
          </div>

        @endif
        <livewire:component.switch-language wire:lazy>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
              <img class="rounded-circle me-lg-2"
                src="{{ Auth::user()->profile_photo_path ? 'storage/' . Auth::user()->profile_photo_path : 'default.png' }}"
                alt="" style="width: 40px; height: 40px;">
              <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary rounded-0 rounded-bottom m-0 border-0">
              <a class="dropdown-item" href="#" wire:click='change_tab("Profile")'>{{ _app('Profile') }}</a>
              <a class="dropdown-item" href="#" wire:click='open_wallet'>{{ _app('Wallet') }}</a>
              @if (user_can_access('client_wallet_access'))
                <a class="dropdown-item" href="#"
                  wire:click='open_client_wallet'>{{ _app('Client_Wallet') }}</a>
              @endif
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
        @if (user_can_access('product_access'))
          @livewire('app.clients.product')
        @endif
      @break

      @case('System')
        @livewire('app.control')
      @break

      @case('Market')
        @livewire('app.market')
      @break

      @case('Cart')
        @livewire('app.cart')
      @break

      @case('Settings')
        @if (user_can_access('business_settings'))
          @livewire('app.clients.settings')
        @endif
      @break

      @case('Community')
        @livewire('app.community', ['email' => $email])
      @break

      @case('Event')
        @if (user_can_access('event_access'))
          @livewire('app.client.event')
        @endif
      @break

      @case('Wallet')
        @livewire('app.wallet')
      @break

      @case('Business')
        @if (user_can_access('business_access'))
          @livewire('app.client')
        @endif
      @break

      @default
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger">
            {{ session('error') }}
          </div>
        @endif
        @if (user_can_access('dashboad_view'))
          <!-- Sale & Revenue Start -->
          <div class="container-fluid px-4 pt-4" wire:lazy>
            <div class="row g-4">
              <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
                  <i class="fa bi-people fa-3x text-primary"></i>
                  <div class="ms-3">
                    <p class="mb-2">{{ _app('Users') }}</p>
                    @if (Auth::user()->id == 1)
                      <h6 class="mb-0 text-right">{{ \App\Models\User::count() }}</h6>
                    @else
                      <h6 class="mb-0 text-right">{{ Auth::user()->client->users->count() }}</h6>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
                  <i class="fa bi-list-check fa-3x text-primary"></i>
                  <div class="ms-3">
                    <p class="mb-2">{{ _app('Tasks') }}</p>
                    <h6 class="mb-0 text-right">{{ Auth::user()->tasks->count() }}</h6>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
                  <i class="fa bi-boxes fa-3x text-primary"></i>
                  <div class="ms-3">
                    <p class="mb-2">{{ _app('Products') }}</p>
                    @if (Auth::user()->id == 1)
                      <h6 class="mb-0 text-right">{{ \App\Models\Product::count() }}</h6>
                    @else
                      <h6 class="mb-0 text-right">{{ Auth::user()->client->available_products->count() }}</h6>
                    @endif
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
                  <i class="fa bi-cart fa-3x text-primary"></i>
                  <div class="ms-3">
                    <p class="mb-2">{{ _app('Cart') }}</p>
                    <h6 class="mb-0 text-right">{{ Auth::user()->cart_items->count() }}</h6>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary d-flex align-items-center justify-content-between rounded p-4">
                  <i class="fa bi-building fa-3x text-primary"></i>
                  <div class="ms-3">
                    <p class="mb-2">{{ _app('Client') }} <span
                        class="text-primary">{{ \App\Models\Client::count() }}</span></p>
                    <h6 class="text-success mb-0 text-right">
                      {{ \App\Models\Client::where('is_verified', true)->count() }} Varified</h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="container-fluid px-4 pt-4">
            @livewire('component.chart.server-request')
          </div>
        @endif
        <livewire:app.client.people lazy />
      @break

    @endswitch
    @if ($view_wallet)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content bg-secondary">
            <div class="modal-body">
              @livewire('app.clients.wallet')
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button"
                wire:click="close_wallet">{{ _app('close') }}</button>
            </div>
          </div>
        </div>
      </div>
    @endif
    @if ($client_wallet_modal)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content bg-secondary">
            <div class="modal-body">
              @livewire('app.clients.wallet', ['client' => true])
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button"
                wire:click="close_client_wallet">{{ _app('close') }}</button>
            </div>
          </div>
        </div>
      </div>
    @endif
    @if ($event_ticket_modal)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog">
          <div class="modal-content bg-secondary">
            <div class="modal-body">
              @livewire('component.card.eventticket', ['id' => $event_ticket->id])
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button"
                wire:click="close_event_ticket">{{ _app('close') }}</button>
            </div>
          </div>
        </div>
      </div>
    @endif
    @if (Auth::user()->white_papers->count() > 0)
      <div class="container-fluid px-4 pt-4">
        <div class="bg-secondary rounded-top row m-4 p-4">
          <h2>{{ _app('White_Paper') }}</h2>
          @foreach (Auth::user()->white_papers as $empowerment)
            <div class="col-lg-6">
              <div class="card border-primary shadow-sm" style='background-color: #00000062;'>
                <div class="card-header d-flex align-items-center justify-content-between">
                  <img class="rounded-circle" src="{{ $empowerment->client->logo() }}"
                    alt="{{ $empowerment->client->name }}" style="width: 40px; height: 40px;" loading="lazy">
                  <h4>{{ $empowerment->client->name }}</h4>
                </div>
                <div class="card-body">
                  <h5 class="card-title">{{ $empowerment->title }}</h5>
                  <p class="card-text">{!! $empowerment->white_paper !!}</p>
                  <p class="card-text">
                    <small class="text-muted">
                      {{ $empowerment->created_at->diffForHumans() }}
                      <span class="text-primary">by</span>
                      {{ $empowerment->hr->name }}
                      <span class="text-primary">to</span>
                      {{ Auth::user()->name }}
                    </small>
                  </p>
                  <button class="btn btn-primary" wire:click='accept_white_paper("{{ write($empowerment->id) }}")'>
                    {{ _app('Accept') }}
                  </button>
                  <button class="btn btn-danger" wire:click='decline_white_paper("{{ write($empowerment->id) }}")'>
                    {{ _app('Decline') }}
                  </button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
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
