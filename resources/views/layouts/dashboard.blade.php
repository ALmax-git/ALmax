<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">

    <!-- Primary Meta Tags -->
    <title>ALmax - Smart CBT Exam System</title>
    <meta name="title" content="ALmax - Smart CBT Exam System">
    <meta name="description"
      content="ALmax is a modern Computer-Based Testing (CBT) system for efficient and secure E-Exams. Supports auto-grading, question banks, and real-time monitoring.">

    <!-- Keywords for SEO -->
    <meta name="keywords"
      content="CBT Software, Online Exams, E-Exams, ALmax, Computer-Based Test, Digital Education, Automated Grading">

    <!-- Author Information -->
    <meta name="author" content="Your Name or Your Company Name">

    <!-- Robots Control -->
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">

    <!-- Open Graph Meta Tags (For Facebook, LinkedIn) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="ALmax - Smart CBT Exam System">
    <meta property="og:description"
      content="ALmax is a modern CBT system for efficient and secure E-Exams. Supports auto-grading, question banks, and real-time monitoring.">
    <meta property="og:image" content="{{ asset('css/guest.css') }}">
    <meta property="og:url" content="https://almax.mn.co">

    <!-- Twitter Card (For Twitter Sharing) -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="ALmax - Smart CBT Exam System">
    <meta name="twitter:description"
      content="ALmax is a modern CBT system for efficient and secure E-Exams. Supports auto-grading, question banks, and real-time monitoring.">
    <meta name="twitter:image" content="{{ asset('css/guest.css') }}">

    <!-- Favicon -->
    <link type="image/x-icon" href="{{ asset('ALmax.png') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap"
      rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    @livewireStyles
  </head>

  <body>
    @yield('content')
    <script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    @livewireScripts
    <script src="{{ asset('node_modules/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <x-livewire-alert::scripts />

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
  </body>

</html>
