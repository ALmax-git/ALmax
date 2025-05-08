<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALmax - Empowering Digital Business</title>
    <meta name="title" content="ALmax - Empowering Digital Business">
    <meta name="description" content="{{ _app('almax_desc') }}">
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
    <!-- Favicons -->
    <link href=build/assets/img/favicon.png" rel="icon">
    <link href=build/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('build/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('build/assets/css/event.css') }}" rel="stylesheet">

  </head>

  <body class="index-page">

    <header class="header d-flex align-items-center fixed-top" id="header">
      <div class="container-fluid container-xl position-relative d-flex align-items-center">

        <a class="logo d-flex align-items-center me-auto" href="index.html">
          <h1 class="sitename">EventPulse</h1>
        </a>

        <nav class="navmenu" id="navmenu">

          <ul class="nav-menu">
            <li class="menu-active"><a href="#intro">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#speakers">Speakers</a></li>
            <li><a href="#schedule">Schedule</a></li>
            <li><a href="#venue">Venue</a></li>
            <li><a href="#sponsors">Sponsors</a></li>
            <li><a href="#contact">Contact</a></li>
            {{-- <li class="buy-tickets"><a href="#buyticket">Buy Tickets</a></li> --}}
          </ul>
          <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <a class="cta-btn d-none d-sm-block" href="#buy-tickets">Buy Tickets</a>

      </div>
    </header>

    <main class="main">

      <!-- Hero Section -->
      <section class="hero section dark-background" id="hero">

        <img class="" data-aos="fade-in" src="{{ asset('build/assets/img/hero-bg.jpg') }}" alt="">

        <div class="d-flex flex-column align-items-center container mt-auto text-center">
          <h2 class="" data-aos="fade-up" data-aos-delay="100">International Conference
            on<br><span>Flood</span> Management 2025
          </h2>
          <p data-aos="fade-up" data-aos-delay="200">About The Event</p>
          <div class="" data-aos="fade-up" data-aos-delay="300">
            <a class="glightbox pulsating-play-btn mt-3" href="https://www.youtube.com/watch?v=Y7f98aduVJ8"></a>
          </div>
        </div>

        <div class="about-info position-relative mt-auto">

          <div class="position-relative container" data-aos="fade-up">
            <div class="row">
              <div class="col-lg-6">
                <h2>About The Event</h2>
                <p>Flooding is more than a seasonal inconvenience — it's a threat to lives, livelihoods, and local
                  infrastructure. The International Conference on Flood Management 2025 brings together experts,
                  government agencies, NGOs, community leaders, and the public to address the critical challenges of
                  flood risk in Borno State and beyond.</p>
              </div>
              <div class="col-lg-3">
                <h3>Where</h3>
                <p>Muhammad Indimi International Conference Center, University of Maiduguri</p>
              </div>
              <div class="col-lg-3">
                <h3>When</h3>
                <p>22 July 2025 by 10:00 AM</p>
              </div>
            </div>
          </div>
        </div>

      </section><!-- /Hero Section -->

      <!-- Speakers Section -->
      <section class="speakers section" id="speakers">

        <!-- Section Title -->
        <div class="section-title container" data-aos="fade-up">
          <h2>Event Speakers<br></h2>

        </div><!-- End Section Title -->

        <div class="container">

          <div class="row gy-4">

            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="member">
                <img class="img-fluid" src="build/assets/img/speakers/speaker-1.jpg" alt="">
                <div class="member-info">
                  <div class="member-info-content">
                    <h4><a href="speaker-details.html">Walter White</a></h4>
                    <span>Quas alias incidunt</span>
                  </div>
                  <div class="social">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div><!-- End Team Member -->

            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="member">
                <img class="img-fluid" src="build/assets/img/speakers/speaker-2.jpg" alt="">
                <div class="member-info">
                  <div class="member-info-content">
                    <h4><a href="speaker-details.html">Hubert Hirthe</a></h4>
                    <span>Consequuntur odio aut</span>
                  </div>
                  <div class="social">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div><!-- End Team Member -->

            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="member">
                <img class="img-fluid" src="build/assets/img/speakers/speaker-3.jpg" alt="">
                <div class="member-info">
                  <div class="member-info-content">
                    <h4><a href="speaker-details.html">Amanda Jepson</a></h4>
                    <span>Fugiat laborum et</span>
                  </div>
                  <div class="social">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div><!-- End Team Member -->

            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
              <div class="member">
                <img class="img-fluid" src="build/assets/img/speakers/speaker-4.jpg" alt="">
                <div class="member-info">
                  <div class="member-info-content">
                    <h4><a href="speaker-details.html">William Anderson</a></h4>
                    <span>Debitis iure vero</span>
                  </div>
                  <div class="social">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                  </div>
                </div>
              </div>
            </div><!-- End Team Member -->

          </div>

        </div>

      </section><!-- /Speakers Section -->

      <!-- Schedule Section -->
      <section class="schedule section" id="schedule">

        <!-- Section Title -->
        <div class="section-title container" data-aos="fade-up">
          <h2>Event Schedule<br></h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container">

          <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-bs-toggle="tab" href="#day-1" role="tab">Day 1</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#day-2" role="tab">Day 2</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#day-3" role="tab">Day 3</a>
            </li>
          </ul>

          <div class="tab-content row justify-content-center" data-aos="fade-up" data-aos-delay="200">

            <h3 class="sub-heading">Voluptatem nulla veniam soluta et corrupti consequatur neque eveniet officia. Eius
              necessitatibus voluptatem quis labore perspiciatis quia.</h3>

            <!-- Schdule Day 1 -->
            <div class="col-lg-9 tab-pane fade show active" id="day-1" role="tabpanel">

              <div class="row schedule-item">
                <div class="col-md-2"><time>09:30 AM</time></div>
                <div class="col-md-10">
                  <h4>Registration</h4>
                  <p>Fugit voluptas iusto maiores temporibus autem numquam magnam.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>10:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-1-2.jpg" alt="Brenden Legros">
                  </div>
                  <h4>Keynote <span>Brenden Legros</span></h4>
                  <p>Facere provident incidunt quos voluptas.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>11:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-2-2.jpg" alt="Hubert Hirthe">
                  </div>
                  <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                  <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>12:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-3-2.jpg" alt="Cole Emmerich">
                  </div>
                  <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                  <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>02:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-4-2.jpg" alt="Jack Christiansen">
                  </div>
                  <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                  <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>03:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-5.jpg" alt="Alejandrin Littel">
                  </div>
                  <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                  <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>04:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-6.jpg" alt="Willow Trantow">
                  </div>
                  <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                  <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
                </div>
              </div>

            </div><!-- End Schdule Day 1 -->

            <!-- Schdule Day 2 -->
            <div class="col-lg-9 tab-pane fade" id="day-2" role="tabpanel">

              <div class="row schedule-item">
                <div class="col-md-2"><time>10:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-1-2.jpg" alt="Brenden Legros">
                  </div>
                  <h4>Libero corrupti explicabo itaque. <span>Brenden Legros</span></h4>
                  <p>Facere provident incidunt quos voluptas.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>11:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-2-2.jpg" alt="Hubert Hirthe">
                  </div>
                  <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                  <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>12:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-3-2.jpg" alt="Cole Emmerich">
                  </div>
                  <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                  <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>02:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-4-2.jpg" alt="Jack Christiansen">
                  </div>
                  <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                  <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>03:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-5.jpg" alt="Alejandrin Littel">
                  </div>
                  <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                  <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>04:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-6.jpg" alt="Willow Trantow">
                  </div>
                  <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                  <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
                </div>
              </div>

            </div><!-- End Schdule Day 2 -->

            <!-- Schdule Day 3 -->
            <div class="col-lg-9 tab-pane fade" id="day-3" role="tabpanel">

              <div class="row schedule-item">
                <div class="col-md-2"><time>10:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-2-2.jpg" alt="Hubert Hirthe">
                  </div>
                  <h4>Et voluptatem iusto dicta nobis. <span>Hubert Hirthe</span></h4>
                  <p>Maiores dignissimos neque qui cum accusantium ut sit sint inventore.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>11:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-3-2.jpg" alt="Cole Emmerich">
                  </div>
                  <h4>Explicabo et rerum quis et ut ea. <span>Cole Emmerich</span></h4>
                  <p>Veniam accusantium laborum nihil eos eaque accusantium aspernatur.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>12:00 AM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-1-2.jpg" alt="Brenden Legros">
                  </div>
                  <h4>Libero corrupti explicabo itaque. <span>Brenden Legros</span></h4>
                  <p>Facere provident incidunt quos voluptas.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>02:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-4-2.jpg" alt="Jack Christiansen">
                  </div>
                  <h4>Qui non qui vel amet culpa sequi. <span>Jack Christiansen</span></h4>
                  <p>Nam ex distinctio voluptatem doloremque suscipit iusto.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>03:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-5.jpg" alt="Alejandrin Littel">
                  </div>
                  <h4>Quos ratione neque expedita asperiores. <span>Alejandrin Littel</span></h4>
                  <p>Eligendi quo eveniet est nobis et ad temporibus odio quo.</p>
                </div>
              </div>

              <div class="row schedule-item">
                <div class="col-md-2"><time>04:00 PM</time></div>
                <div class="col-md-10">
                  <div class="speaker">
                    <img src="build/assets/img/speakers/speaker-6.jpg" alt="Willow Trantow">
                  </div>
                  <h4>Quo qui praesentium nesciunt <span>Willow Trantow</span></h4>
                  <p>Voluptatem et alias dolorum est aut sit enim neque veritatis.</p>
                </div>
              </div>

            </div><!-- End Schdule Day 3 -->

          </div>

        </div>
      </section><!-- /Schedule Section -->

      <!-- Venue Section -->
      <section class="venue section" id="venue">

        <!-- Section Title -->
        <div class="section-title container" data-aos="fade-up">
          <h2>Event Venue<br></h2>
          <p>Muhammad Indimi International Conference Hall, University of Maiduguri.</h3>
          <p>We wait for you at the International Conference on flood Management 2025</p>
        </div><!-- End Section Title -->

        <div class="container-fluid" data-aos="fade-up">

          <div class="row g-0">
            <div class="col-lg-6 venue-map">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
                style="border:0" frameborder="0" allowfullscreen=""></iframe>
            </div>

            <div class="col-lg-6 venue-info">
              <div class="row justify-content-center">
                <div class="col-11 col-lg-8 position-relative">
                  <h3>Borno State, Nigeria</h3>
                  <p>Muhammad Indimi International Conference Hall, University of Maiduguri.</h3>
                  <p>We wait for you at the International Conference on flood Management 2025.</p>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="container-fluid venue-gallery-container" data-aos="fade-up" data-aos-delay="100">
          <div class="row g-0">

            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a class="glightbox" data-gall="venue-gallery"
                  href=build/assets/img/venue-gallery/venue-gallery-1.jpg">
                  <img class="img-fluid" src="build/assets/img/venue-gallery/venue-gallery-1.jpg" alt="">
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a class="glightbox" data-gall="venue-gallery"
                  href=build/assets/img/venue-gallery/venue-gallery-2.jpg">
                  <img class="img-fluid" src="build/assets/img/venue-gallery/venue-gallery-2.jpg" alt="">
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a class="glightbox" data-gall="venue-gallery"
                  href=build/assets/img/venue-gallery/venue-gallery-3.jpg">
                  <img class="img-fluid" src="build/assets/img/venue-gallery/venue-gallery-3.jpg" alt="">
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a class="glightbox" data-gall="venue-gallery"
                  href=build/assets/img/venue-gallery/venue-gallery-4.jpg">
                  <img class="img-fluid" src="build/assets/img/venue-gallery/venue-gallery-4.jpg" alt="">
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a class="glightbox" data-gall="venue-gallery"
                  href=build/assets/img/venue-gallery/venue-gallery-5.jpg">
                  <img class="img-fluid" src="build/assets/img/venue-gallery/venue-gallery-5.jpg" alt="">
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a class="glightbox" data-gall="venue-gallery"
                  href=build/assets/img/venue-gallery/venue-gallery-6.jpg">
                  <img class="img-fluid" src="build/assets/img/venue-gallery/venue-gallery-6.jpg" alt="">
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a class="glightbox" data-gall="venue-gallery"
                  href=build/assets/img/venue-gallery/venue-gallery-7.jpg">
                  <img class="img-fluid" src="build/assets/img/venue-gallery/venue-gallery-7.jpg" alt="">
                </a>
              </div>
            </div>

            <div class="col-lg-3 col-md-4">
              <div class="venue-gallery">
                <a class="glightbox" data-gall="venue-gallery"
                  href=build/assets/img/venue-gallery/venue-gallery-8.jpg">
                  <img class="img-fluid" src="build/assets/img/venue-gallery/venue-gallery-8.jpg" alt="">
                </a>
              </div>
            </div>

          </div>
        </div>

      </section><!-- /Venue Section -->

      {{-- <!-- Hotels Section -->
      <section class="hotels section" id="hotels">

        <!-- Section Title -->
        <div class="section-title container" data-aos="fade-up">
          <h2>Hotels</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container">

          <div class="row gy-4">

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
              <div class="card h-100">
                <div class="card-img">
                  <img class="img-fluid" src="build/assets/img/hotels-1.jpg" alt="">
                </div>
                <h3><a class="stretched-link" href="#">Non quibusdam blanditiis</a></h3>
                <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                <p>0.4 Mile from the Venue</p>
              </div>
            </div><!-- End Card Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
              <div class="card h-100">
                <div class="card-img">
                  <img class="img-fluid" src="build/assets/img/hotels-2.jpg" alt="">
                </div>
                <h3><a class="stretched-link" href="#">Aspernatur assumenda</a></h3>
                <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                <p>0.5 Mile from the Venue</p>
              </div>
            </div><!-- End Card Item -->

            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
              <div class="card h-100">
                <div class="card-img">
                  <img class="img-fluid" src="build/assets/img/hotels-3.jpg" alt="">
                </div>
                <h3><a class="stretched-link" href="#">Dolores ut ut voluptatibu</a></h3>
                <div class="stars"><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i
                    class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></div>
                <p>0.6 Mile from the Venue</p>
              </div>
            </div><!-- End Card Item -->

          </div>

        </div>

      </section><!-- /Hotels Section --> --}}

      <!-- Gallery Section -->
      <section class="gallery section" id="gallery">

        <!-- Section Title -->
        <div class="section-title container" data-aos="fade-up">
          <h2>Gallery</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

          <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "centeredSlides": true,
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 0
                },
                "768": {
                  "slidesPerView": 3,
                  "spaceBetween": 20
                },
                "1200": {
                  "slidesPerView": 5,
                  "spaceBetween": 20
                }
              }
            }
          </script>
            <div class="swiper-wrapper align-items-center">
              <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                  href=build/assets/img/event-gallery/event-gallery-1.jpg"><img class="img-fluid"
                    src="build/assets/img/event-gallery/event-gallery-1.jpg" alt=""></a></div>
              <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                  href=build/assets/img/event-gallery/event-gallery-2.jpg"><img class="img-fluid"
                    src="build/assets/img/event-gallery/event-gallery-2.jpg" alt=""></a></div>
              <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                  href=build/assets/img/event-gallery/event-gallery-3.jpg"><img class="img-fluid"
                    src="build/assets/img/event-gallery/event-gallery-3.jpg" alt=""></a></div>
              <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                  href=build/assets/img/event-gallery/event-gallery-4.jpg"><img class="img-fluid"
                    src="build/assets/img/event-gallery/event-gallery-4.jpg" alt=""></a></div>
              <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                  href=build/assets/img/event-gallery/event-gallery-5.jpg"><img class="img-fluid"
                    src="build/assets/img/event-gallery/event-gallery-5.jpg" alt=""></a></div>
              <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                  href=build/assets/img/event-gallery/event-gallery-6.jpg"><img class="img-fluid"
                    src="build/assets/img/event-gallery/event-gallery-6.jpg" alt=""></a></div>
              <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                  href=build/assets/img/event-gallery/event-gallery-7.jpg"><img class="img-fluid"
                    src="build/assets/img/event-gallery/event-gallery-7.jpg" alt=""></a></div>
              <div class="swiper-slide"><a class="glightbox" data-gallery="images-gallery"
                  href=build/assets/img/event-gallery/event-gallery-8.jpg"><img class="img-fluid"
                    src="build/assets/img/event-gallery/event-gallery-8.jpg" alt=""></a></div>
            </div>
            <div class="swiper-pagination"></div>
          </div>

        </div>

      </section><!-- /Gallery Section -->

      <!-- Sponsors Section -->
      <section class="sponsors section light-background" id="sponsors">

        <!-- Section Title -->
        <div class="section-title container" data-aos="fade-up">
          <h2>Sponsors</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

          <div class="row g-0 clients-wrap">

            <div class="col-xl-3 col-md-4 client-logo">
              <img class="img-fluid" src="build/assets/img/clients/client-1.png" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-3 col-md-4 client-logo">
              <img class="img-fluid" src="build/assets/img/clients/client-2.png" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-3 col-md-4 client-logo">
              <img class="img-fluid" src="build/assets/img/clients/client-3.png" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-3 col-md-4 client-logo">
              <img class="img-fluid" src="build/assets/img/clients/client-4.png" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-3 col-md-4 client-logo">
              <img class="img-fluid" src="build/assets/img/clients/client-5.png" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-3 col-md-4 client-logo">
              <img class="img-fluid" src="build/assets/img/clients/client-6.png" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-3 col-md-4 client-logo">
              <img class="img-fluid" src="build/assets/img/clients/client-7.png" alt="">
            </div><!-- End Client Item -->

            <div class="col-xl-3 col-md-4 client-logo">
              <img class="img-fluid" src="build/assets/img/clients/client-8.png" alt="">
            </div><!-- End Client Item -->

          </div>

        </div>

      </section><!-- /Sponsors Section -->

      <!-- Faq Section -->
      <section class="faq section" id="faq">

        <!-- Section Title -->
        <div class="section-title container" data-aos="fade-up">
          <h2>Frequently Asked Questions</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container">

          <div class="row justify-content-center">

            <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

              <div class="faq-container">

                <div class="faq-item faq-active">
                  <h3>How do I book a seat for the conference?</h3>
                  <div class="faq-content">
                    <p>To book a seat, visit our conference reservation page, fill in your details, and complete the
                      payment using our secure online payment system. After payment, you will receive a confirmation
                      email and a downloadable receipt.</p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div><!-- End Faq item-->

                <div class="faq-item">
                  <h3>What payment methods are accepted?</h3>
                  <div class="faq-content">
                    <p>We accept online payments via Paystack, which allows you to pay using ATM cards (Visa,
                      Mastercard, Verve) and bank transfers. All transactions are secure and encrypted.</p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div><!-- End Faq item-->

                <div class="faq-item">
                  <h3>Will I receive a receipt after payment?</h3>
                  <div class="faq-content">
                    <p>Yes, once your payment is successfully processed, you will receive a PDF ticket with your details
                      and payment status.</p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div><!-- End Faq item-->

                <div class="faq-item">
                  <h3>Can I get a refund if I can’t attend the conference?</h3>
                  <div class="faq-content">
                    <p>You can't refund your money after making payment.</p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div><!-- End Faq item-->

                <div class="faq-item">
                  <h3>Do I need to create an account to make a reservation?</h3>
                  <div class="faq-content">
                    <p>No, you do not need to create an account. You can simply fill in your details, make the payment,
                      and receive your confirmation instantly.</p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div><!-- End Faq item-->

                <div class="faq-item">
                  <h3>Where will the conference take place, and how do I get there?</h3>
                  <div class="faq-content">
                    <p>The conference will be held at Muhammad Indimi International Conference Hall, University of
                      Maiduguri, in Borno State. Directions and venue details will be provided in your booking
                      confirmation email.</p>
                  </div>
                  <i class="faq-toggle bi bi-chevron-right"></i>
                </div><!-- End Faq item-->

              </div>

            </div><!-- End Faq Column-->

          </div>

        </div>

      </section><!-- /Faq Section -->

      @livewire('app.events.control')
      <!-- Contact Section -->
      <section class="contact section" id="contact">

        <!-- Section Title -->
        <div class="section-title container" data-aos="fade-up">
          <h2>Contact</h2>
          <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

          <div class="row gy-4">

            <div class="col-lg-6">
              <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up"
                data-aos-delay="200">
                <i class="bi bi-geo-alt"></i>
                <h3>Address</h3>
                <p>Cock Center at Ramat Polytechnic Maiduguri</p>
              </div>
            </div><!-- End Info Item -->

            <div class="col-lg-3 col-md-6">
              <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up"
                data-aos-delay="300">
                <i class="bi bi-telephone"></i>
                <h3>Call Us</h3>
                <p>+234 81 6514 1519</p>
              </div>
            </div><!-- End Info Item -->

            <div class="col-lg-3 col-md-6">
              <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up"
                data-aos-delay="400">
                <i class="bi bi-envelope"></i>
                <h3>Email Us</h3>
                <p>abituho7s@mozmail.com</p>
              </div>
            </div><!-- End Info Item -->

          </div>

          <div class="row gy-4 mt-1">
            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus"
                style="border:0; width: 100%; height: 400px;" frameborder="0" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div><!-- End Google Maps -->

            <div class="col-lg-6">
              <form class="php-email-form" data-aos="fade-up" data-aos-delay="400" action="forms/contact.php"
                method="post">
                <div class="row gy-4">

                  <div class="col-md-6">
                    <input class="form-control" name="name" type="text" placeholder="Your Name"
                      required="">
                  </div>

                  <div class="col-md-6">
                    <input class="form-control" name="email" type="email" placeholder="Your Email"
                      required="">
                  </div>

                  <div class="col-md-12">
                    <input class="form-control" name="subject" type="text" placeholder="Subject" required="">
                  </div>

                  <div class="col-md-12">
                    <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                  </div>

                  <div class="col-md-12 text-center">
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div>

                    <button type="submit">Send Message</button>
                  </div>

                </div>
              </form>
            </div><!-- End Contact Form -->

          </div>

        </div>

      </section><!-- /Contact Section -->

    </main>

    <footer class="footer dark-background" id="footer">

      <div class="footer-top">
        <div class="container">
          <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
              <a class="logo d-flex align-items-center" href="index.html">
                <span class="sitename">EventPulse</span>
              </a>
              <div class="footer-contact pt-3">
                <p>Borno State Nigeria</p>
                <p>Cock Center at Ramat Polytechnic Maiduguri</p>
                <p class="mt-3"><strong>Phone:</strong> <span>+234 81 6514 1519</span></p>
                <p><strong>Email:</strong> <span>abituho7s@mozmail.com</span></p>
              </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
              <h4>Useful Links</h4>
              <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About us</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Terms of service</a></li>
                <li><a href="#">Privacy policy</a></li>
              </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
              <h4>Our Services</h4>
              <ul>
                <li><a href="#">Web Design</a></li>
                <li><a href="#">Web Development</a></li>
                <li><a href="#">Product Management</a></li>
                <li><a href="#">Marketing</a></li>
                <li><a href="#">Graphic Design</a></li>
              </ul>
            </div>

            {{-- <div class="col-lg-2 col-md-3 footer-links">
              <h4>Hic solutasetp</h4>
              <ul>
                <li><a href="#">Molestiae accusamus iure</a></li>
                <li><a href="#">Excepturi dignissimos</a></li>
                <li><a href="#">Suscipit distinctio</a></li>
                <li><a href="#">Dilecta</a></li>
                <li><a href="#">Sit quas consectetur</a></li>
              </ul>
            </div> --}}

            {{-- <div class="col-lg-2 col-md-3 footer-links">
              <h4>Nobis illum</h4>
              <ul>
                <li><a href="#">Ipsam</a></li>
                <li><a href="#">Laudantium dolorum</a></li>
                <li><a href="#">Dinera</a></li>
                <li><a href="#">Trodelas</a></li>
                <li><a href="#">Flexo</a></li>
              </ul>
            </div> --}}

          </div>
        </div>
      </div>

      <div class="copyright text-center">
        <div class="container-fluid px-4 pt-4">
          <div class="bg-secondary rounded-top mt-2 p-4">
            <div class="col-12 col-sm-6 text-sm-start text-center">
              <p>&copy; <strong>ALmax</strong>, {{ _app('copyright') }}.</p>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scroll Top -->
    <a class="scroll-top d-flex align-items-center justify-content-center" id="scroll-top" href="#"><i
        class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    {{-- <div id="preloader"></div> --}}

    <!-- Vendor JS Files -->
    <script src="build/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="build/assets/vendor/php-email-form/validate.js"></script>
    <script src="build/assets/vendor/aos/aos.js"></script>
    <script src="build/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="build/assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    {{-- <script src="build/assets/js/event.js"></script> --}}
    <script src="{{ asset('build/assets/js/event.js') }}"></script>

  </body>

</html>
