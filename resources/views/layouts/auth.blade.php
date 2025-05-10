<!DOCTYPE html>
<html class="light-style customizer-hide" data-theme="theme-default" data-assets-path="build/assets/" lang="en"
  dir="ltr">

  <head>
    <meta charset="utf-8" />
    <meta name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>ALmax - Gate</title>
    <meta name="description" content="" />
    <link type="image/x-icon" href="{{ asset('build/assets/img/favicon/favicon.ico') }}" rel="icon" />
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
    <link href="{{ asset('build/assets/vendor/fonts/boxicons.css') }}" rel="stylesheet" />
    <link class="template-customizer-core-css" href="{{ asset('build/assets/vendor/css/core.css') }}"
      rel="stylesheet" />
    <link class="template-customizer-theme-css" href="{{ asset('build/assets/vendor/css/theme-default.css') }}"
      rel="stylesheet" />
    <link href="{{ asset('build/assets/css/demo.css') }}" rel="stylesheet" />
    <link href="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
    <link href="{{ asset('build/assets/vendor/css/pages/page-auth.css') }}" rel="stylesheet" />
    <script src="{{ asset('build/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('build/assets/js/config.js') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" /> --}}
    @livewireStyles
  </head>

  <body>
    <style>
      * {
        color: black !important;
      }
    </style>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <a class="app-brand-link" href="/">
                  <h1 class="fw-bolder"><u>ALmax</u> {{-- 🔒 --}}</h1>
                </a>
              </div>
              @yield('content')
            </div>
          </div>
        </div>
      </div>
    </div>
    @livewireScripts
    <script src="{{ asset('build/assets/vendors/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <x-livewire-alert::scripts />
    <!-- Include IntlTelInput CSS and JS -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
    <script src="{{ asset('build/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('build/assets/js/main.js') }}"></script>
  </body>

</html>
