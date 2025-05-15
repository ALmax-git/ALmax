<div class="container-fluid position-relative d-flex noselect p-0">
  <style>
    .form-control {
      background-color: #000 !important;
      color: #ffffff !important;
      border: 1px solid #09002ee3 !important;
    }

    .card {
      transition: transform 0.3s ease-in-out;
    }

    .card:hover {
      transform: scale(1.01);
    }
  </style>

  <!-- Content Start -->
  <div class="content open">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
      <a class="navbar-brand d-flex d-lg-none me-4" href="/">
        <h2 class="text-primary mb-0 text-right"><i class="bi bi-user-edit"></i></h2>
      </a>
      <a class="navbar-brand fa-2x mx-4" href="/">
        <i class="bi bi-boxes text-black"
          style="background-color: black; color: white !important;  border: 3px solid black;"></i><span
          style="background-color: black; color: white !important; border: 3px solid black;">Node</span><span
          style="border: 3px solid black;">Pulse</span>
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
              <a class="dropdown-item p-3" href="#" wire:click='change_tab("Event")'>{{ _app('View_All') }}</a>
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
              <a class="dropdown-item" href="#" wire:click='open_profile_view'>{{ _app('Profile') }}</a>
              {{-- <a class="dropdown-item" href="#" wire:click='open_wallet'>{{ _app('Wallet') }}</a>
              @if (user_can_access('client_wallet_access'))
                <a class="dropdown-item" href="#" wire:click='open_client_wallet'>{{ _app('Client_Wallet') }}</a>
              @endif --}}
              <a class="dropdown-item" href="#" wire:click='logout'>{{ _app('logout') }}</a>
            </div>
          </div>
      </div>
    </nav>
    @if (user_can_access('product_access'))
      @livewire('app.clients.product')
    @endif
    @if (user_can_access('sales_access') || user_can_access('manage_sales'))
      @livewire('app.client.sales', ['sale_list_view' => true])
    @endif
    @if ($profile_view)
      <div class="modal" tabindex="-1" style="display:block;">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content bg-dark" style="background-color: #000; border: 2px solid blue;">
            <div class="modal-body">
              @livewire('component.profile')
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" type="button"
                wire:click="close_profile_view">{{ _app('close') }}</button>
            </div>
          </div>
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
</div>
