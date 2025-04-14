<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- Meta Basics -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary Meta Tags -->
    <title>ALmax - Empowering Digital Business</title>
    <meta name="title" content="ALmax - Empowering Digital Business">
    <meta name="description"
      content="ALmax is a dynamic digital ecosystem for businesses, individuals, and organizations—offering powerful tools for management, payment, logistics, HR, marketing, and innovation.">
    <meta name="keywords"
      content="ALmax, Business Software, HRM, ERP, Digital Marketplace, Payments, Logistics, Web3, Innovation, Business Management, Client Empowerment">
    <meta name="author" content="ALmax Team">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">

    <!-- Open Graph / Facebook / LinkedIn -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="ALmax - Empowering Digital Business">
    <meta property="og:description"
      content="ALmax is a digital ecosystem empowering business management, smart payments, HR systems, client tools, and global innovation.">
    <meta property="og:image" content="{{ asset('build/assets/almax-preview.png') }}">
    <meta property="og:url" content="https://almax.mn.co">

    <!-- Twitter Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ALmax - Empowering Digital Business">
    <meta name="twitter:description"
      content="Explore ALmax: an all-in-one digital platform for business, HR, logistics, payment, and global innovation.">
    <meta name="twitter:image" content="{{ asset('build/assets/almax-preview.png') }}">
    <meta name="twitter:site" content="@ALmax">
    <meta name="twitter:creator" content="@ALmax">
    <meta name="twitter:domain" content="almax.mn.co">
    <meta name="twitter:site" content="@ALmax">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image:alt" content="ALmax - Empowering Digital Business">
    <!-- Whatsapp Meta -->
    <meta property="og:site_name" content="ALmax - Empowering Digital Business">
    <meta property="og:locale" content="en_US">
    <meta property="og:locale:alternate" content="mn_MN">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:alt" content="ALmax - Empowering Digital Business">
    <meta property="og:image:secure_url" content="{{ asset('build/assets/almax-preview.png') }}">
    {{-- <meta property="og:image:width" content="1200"> --}}

    <!-- Favicon -->
    <link type="image/x-icon" href="{{ asset('build/assets/almax-preview.png') }}" rel="icon">

    <link href="{{ asset('build/assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Conditional Styles -->
    @auth
      @if (Auth::user())
        <!-- Icons and Libraries -->
        <link href="{{ asset('build/assets/css/icons.css') }}" rel="stylesheet">
        <link href="{{ asset('build/assets/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('node_modules/bootstrap-icons/font/bootstrap-icons.min.css') }}" rel="stylesheet">
        <link href="{{ asset('build/assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
        {{-- <link href="{{ asset('build/assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet"> --}}

        <!-- App Styles -->
        <link href="{{ asset('build/assets/css/style.css') }}" rel="stylesheet">
      @else
        <link href="{{ asset('build/assets/css/app.css') }}" rel="stylesheet">
      @endif
    @else
      <link href="{{ asset('build/assets/css/guest.css') }}" rel="stylesheet">
    @endauth

    @livewireStyles
  </head>

  <body class="noselect">

    @yield('content')

    @livewireScripts

    @auth
      @if (Auth::user())
        <!-- Charts & Plugins -->
        <script src="{{ asset('node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
        <x-livewire-alert::scripts />
        <script src="{{ asset('build/assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('node_modules/@popperjs/core/dist/umd/popper.min.js') }}"></script>
        <script src="{{ asset('build/assets/lib/easing/easing.min.js') }}"></script>
        <script src="{{ asset('build/assets/lib/waypoints/waypoints.min.js') }}"></script>
        <script src="{{ asset('build/assets/lib/owlcarousel/assets/owl.carousel.min.css') }}"></script>
        <script src="{{ asset('build/assets/lib/tempusdominus/js/moment.min.js') }}"></script>
        <script src="{{ asset('build/assets/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
        <script src="{{ asset('build/assets/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

        <!-- Main Script -->
        <script src="{{ asset('build/assets/js/main.js') }}"></script>
      @endif
    @endauth

  </body>

</html>
