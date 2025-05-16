<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ALmax - Index</title>
    <link href="build/assets/css/fontawesome.css" rel="stylesheet">
    <link href="build/assets/css/ALmax.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
      rel="stylesheet">
    <style>
      @keyframes pulseGlow {
        0% {
          text-shadow: 0 0 1px #fff, 0 0 1px #ff80ff, 0 0 1px #ff80ff, 0 0 1px #ff80ff, 0 0 1px #ff80ff;
        }

        50% {
          text-shadow: 0 0 2px #fff, 0 0 2px #ff4dff, 0 0 2px #ff1aff, 0 0 2px #ff00ff, 0 0 2px #ff00ff;
        }

        100% {
          text-shadow: 0 0 1px #fff, 0 0 2px #ff80ff, 0 0 1px #ff80ff, 0 0 2px #ff80ff, 0 0 1px #ff80ff;
        }
      }

      @keyframes gradientText {
        0% {
          background-position: 0% 50%;
        }

        50% {
          background-position: 100% 50%;
        }

        100% {
          background-position: 0% 50%;
        }
      }

      .logo {
        font-weight: bold;
        color: transparent;
        margin-right: 4px;
        background: linear-gradient(45deg, #ff00ff, #ff80ff, #8000ff, #4d00ff);
        -webkit-background-clip: text;
        background-clip: text;
        animation: gradientText 5s ease infinite, pulseGlow 2s infinite;
        text-shadow: 0 0 5px #fff, 0 0 10px #ff80ff, 0 0 20px #ff80ff, 0 0 30px #ff80ff, 0 0 40px #ff80ff;
        display: inline-block;
        border: 2px solid transparent;
        border-image: linear-gradient(45deg, #ff00ff, #ff80ff, #8000ff, #4d00ff);
        border-image-slice: 1;
        border-radius: 15px;
      }
    </style>
    @livewireStyles
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark menu fixed-top shadow">
      <div class="container">
        <div class="d-flex">
          <div class="d-flex">
            <b class="display-3--title logo">&nbsp;ALmax&nbsp;</b>
          </div>
          <livewire:home.search />
        </div>
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav" type="button"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse justify-content-end collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link active" href="index.html" aria-current="page">Home</a>
            </li>
            <li class="nav-item"><a class="nav-link" href="#services" wire:navigate>Services</a></li>
            <li class="nav-item"><a class="nav-link" href="#testimonials" wire:navigate>Market</a></li>
            <li class="nav-item"><a class="nav-link" href="#faq" wire:navigate>faq</a></li>
            <li class="nav-item"><a class="nav-link" href="https://almax.mn.co">Community</a></li>
            <li class="nav-item"><a class="nav-link" href="#contact" wire:navigate>contact</a>
            </li>
          </ul>
          <a class="btn rounded-pill btn-rounded" href="{{ route('gate') }}">
            Account
            <span>
              <i class="fas fa-arrow-right"></i>
            </span>
          </a>
        </div>
      </div>
    </nav>
    <section class="intro-section" id="home">
      <div class="container">
        <div class="row align-items-center text-white">
          <!-- START THE CONTENT FOR THE INTRO  -->
          <div class="col-md-6 intros text-start">
            <h1 class="display-2">
              <span class="display-2--intro">Hey!, I'm ALmax</span>
              <span class="display-2--description lh-base">
                Welcome to ALmax, where dreams become reality and the power of technology knows no boundaries..
              </span>
            </h1>
            <div class="w-50">
              <a class="btn btn-light rounded-pill btn-rounded" href="{{ route('gate') }}" wire:navigate>
                Get in Touch
                <span><i class="fas fa-arrow-right"></i></span>
              </a>
            </div>
          </div>
          <!-- START THE CONTENT FOR THE VIDEO -->
          <div class="col-md-6 intros text-end">
            <div class="video-box">
              <img class="img-fluid" src="images/arts/intro-section-illustration.png" alt="video illutration">
              <a class="glightbox position-absolute top-50 start-50 translate-middle" href="#">
                <span>
                  <i class="fas fa-play-circle"></i>
                </span>
                <span class="border-animation border-animation--border-1"></span>
                <span class="border-animation border-animation--border-2"></span>
              </a>
            </div>
          </div>
        </div>
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#ffffff" fill-opacity="1"
          d="M0,160L48,176C96,192,192,224,288,208C384,192,480,128,576,133.3C672,139,768,213,864,202.7C960,192,1056,96,1152,74.7C1248,53,1344,107,1392,133.3L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
        </path>
      </svg>
    </section>

    {{-- <section id="campanies" class="campanies">
            <div class="container">
                <div class="row text-center">
                    <h4 class="fw-bold lead mb-3">Trusted by campanies like</h4>
                    <div class="heading-line mb-5"></div>
                </div>
            </div>
            <!-- START THE CAMPANIES CONTENT  -->
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-lg-2">
                        <div class="campanies__logo-box shadow-sm">
                            <img src="images/campanies/campany-1.png" alt="Campany 1 logo" title="Campany 1 Logo"
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="campanies__logo-box shadow-sm">
                            <img src="images/campanies/campany-2.png" alt="Campany 2 logo" title="Campany 2 Logo"
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="campanies__logo-box shadow-sm">
                            <img src="images/campanies/campany-3.png" alt="Campany 3 logo" title="Campany 3 Logo"
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="campanies__logo-box shadow-sm">
                            <img src="images/campanies/campany-4.png" alt="Campany 4 logo" title="Campany 4 Logo"
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="campanies__logo-box shadow-sm">
                            <img src="images/campanies/campany-5.png" alt="Campany 5 logo" title="Campany 5 Logo"
                                class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-4 col-lg-2">
                        <div class="campanies__logo-box shadow-sm">
                            <img src="images/campanies/campany-6.png" alt="Campany 6 logo" title="Campany 6 Logo"
                                class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </section> --}}

    <section class="services" id="services">
      <div class="container">
        <div class="row text-center">
          <h1 class="display-3 fw-bold">Our Services</h1>
          <div class="heading-line mb-1"></div>
        </div>
        <!-- START THE DESCRIPTION CONTENT  -->
        <div class="row mb-3 mt-0 pb-2 pt-2">
          <div class="col-md-6 border-right">
            <div class="text-dark bg-white p-3">
              <h2 class="fw-bold text-capitalize text-center">
                Our Services Range From Initial Design To Deployment Anywhere Anytime.
              </h2>
            </div>
          </div>
          <div class="col-md-6">
            <div class="text-dark bg-white p-4 text-start">
              <p class="fw-dark">
                At ALmax, we believe in the power of technology to drive positive change and unlock new possibilities.
                Our vision is to
                create a digital ecosystem where individuals can succeed, businesses can prosper, and communities can
                flourish. By
                utilizing the latest advancements in web design, and development, computer skills, and other talents, we
                are committed
                to delivering exceptional solutions that address the unique needs and challenges of our clients.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- START THE CONTENT FOR THE SERVICES  -->
      <div class="container">
        <!-- START THE MARKETING CONTENT  -->
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4">
            <div class="services__content">
              <div class="icon d-block fas fa-paper-plane"></div>
              <h3 class="display-3--title mt-1">Marketing</h3>
              <p class="text-dark text-dark">
                Our digital marketing services help businesses reach their target audience, increase brand visibility,
                and drive
                conversions. We employ strategic planning, search engine optimization (SEO), social media marketing,
                content creation,
                and other techniques to maximize online presence and generate measurable results.
              </p>
              <button class="rounded-pill btn-rounded border-primary" type="button">Learn more
                <span><i class="fas fa-arrow-right"></i></span>
              </button>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4 text-end">
            <div class="services__pic">
              <img class="img-fluid" src="images/services/service-1.png" alt="marketing illustration">
            </div>
          </div>
        </div>
        <!-- START THE WEB DEVELOPMENT CONTENT  -->
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4 text-start">
            <div class="services__pic">
              <img class="img-fluid" src="images/services/service-2.png" alt="web development illustration">
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4">
            <div class="services__content">
              <div class="icon d-block fas fa-code"></div>
              <h3 class="display-3--title mt-1">Software and Web development</h3>
              <p class="text-dark">
                We develop customized software applications that streamline business processes, increase efficiency, and
                enhance
                productivity. From enterprise-level software to mobile applications, we create solutions that meet
                specific requirements
                and deliver a seamless user experience.
                <br>
                We also specialize in designing and developing professional, visually appealing, and user-friendly
                websites. Our team of
                skilled designers and developers ensure that each website is tailored to the client's brand, objectives,
                and target
                audience.
              </p>
              <button class="rounded-pill btn-rounded border-primary" type="button">Learn more
                <span><i class="fas fa-arrow-right"></i></span>
              </button>
            </div>
          </div>
        </div>
        <!-- START THE CLOUD HOSTING CONTENT  -->
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4">
            <div class="services__content">
              <div class="icon d-block fas fa-cloud-upload-alt"></div>
              <h3 class="display-3--title mt-1">Cloud-based services</h3>
              <p class="text-dark">
                ALmax maintains a robust and secure technology infrastructure to support its operations. This includes a
                high-speed
                internet connection, data storage systems, backup solutions, and cloud-based services. The technology
                infrastructure is
                designed to handle the demands of web design, web development, and other digital services provided by
                ALmax.
              </p>
              <button class="rounded-pill btn-rounded border-primary" type="button">Learn more
                <span><i class="fas fa-arrow-right"></i></span>
              </button>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 services mt-4 text-end">
            <div class="services__pic">
              <img class="img-fluid" src="images/services/service-3.png" alt="cloud hosting illustration">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ////////////////////////////////////////////////////////////////////////////////////////////////
                               START SECTION 5 - THE TESTIMONIALS
/////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <section class="testimonials" id="testimonials">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#fff" fill-opacity="1"
          d="M0,96L48,128C96,160,192,224,288,213.3C384,203,480,117,576,117.3C672,117,768,203,864,202.7C960,203,1056,117,1152,117.3C1248,117,1344,203,1392,245.3L1440,288L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z">
        </path>
      </svg>
      <div class="container">
        <div class="row text-center text-white">
          <h1 class="display-3 fw-bold">An Overview</h1>
          <hr class="mx-auto" style="width: 100px; height: 3px; ">
          <p class="lead pt-1">
            With a customer-centric approach, ALmax places great importance on understanding our clients' goals and
            objectives. We
            collaborate closely with them, offering tailored solutions and personalized support to help them achieve
            their desired
            outcomes. Whether it's building a dynamic website, developing custom software, or providing digital
            marketing
            strategies, we are dedicated to empowering our clients with the tools they need to thrive in the digital
            age.
            <br>
            <hr>
            ALmax is not just a technology company; it is a community of passionate individuals driven by a shared
            vision. We foster
            a culture of continuous learning, collaboration, and growth, encouraging our team members to push boundaries
            and explore
            new horizons. We believe in the power of diversity, and equal opportunities, creating an environment that
            nurtures
            creativity, innovation, and mutual respect.
            <br>
            <hr>
            As we embark on this exciting journey, we invite you to join us and be a part of the ALmax experience.
            Together, we can
            shape the future of technology in Africa, unlocking endless possibilities and creating a legacy that will
            transcend
            generations. Welcome to ALmax, where dreams become reality and the power of technology knows no boundaries
          </p>
        </div>

        <div class="row text-center text-white">
          <h1 class="display-3 fw-bold">Our Mission</h1>
          <hr class="mx-auto" style="width: 100px; height: 3px; ">
          <p class="lead pt-1">
            Our mission at ALmax is to revolutionize the world of technology in Africa. We are dedicated to promoting
            goods and
            services, driving innovation, and nurturing creativity. By providing comprehensive training and skills
            acquisition
            programs, we empower individuals and businesses to thrive in the digital landscape. Through our commitment
            to delivering
            high-quality content, relevant information, and exceptional service, we aim to be the go-to resource for our
            users. Our
            ultimate goal is to inspire and enable our users to reach their full potential and achieve their dreams.
          </p>
        </div>

        <div class="row text-center text-white">
          <h1 class="display-3 fw-bold">Our Vision</h1>
          <hr class="mx-auto" style="width: 100px; height: 3px; ">
          <p class="lead pt-1">
            Our vision is to be the leading provider of technology solutions, recognized for our exceptional quality,
            innovation,
            and impact. We envision a future where technology is accessible to all, empowering individuals to unlock
            their full
            potential, businesses to thrive in the digital economy, and communities to flourish in the age of digital
            transformation. Through our relentless pursuit of excellence and our commitment to creating meaningful
            change, we strive
            to shape a brighter future for Africa, where technology becomes an enabler of progress and prosperity.
          </p>
        </div>
        <!-- START THE CAROUSEL CONTENT  -->
        {{-- <div class="row align-items-center">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <!-- CAROUSEL ITEM 1 -->
                            <div class="carousel-item active">
                                <!-- testimonials card  -->
                                <div class="testimonials__card">
                                    <p class="text-dark">
                                        <i class="fas fa-quote-left"></i>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Placeat aut consequatur illo animi optio exercitationem doloribus eligendi iusto
                                        atque repudiandae. Distinctio.
                                        <i class="fas fa-quote-right"></i>
                                    <div class="ratings p-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    </p>
                                </div>
                                <!-- client picture  -->
                                <div class="testimonials__picture">
                                    <img src="images/testimonials/client-1.jpg" alt="client-1 picture"
                                        class="rounded-circle img-fluid">
                                </div>
                                <!-- client name & role  -->
                                <div class="testimonials__name">
                                    <h3>Patrick Muriungi</h3>
                                    <p class="fw-dark">CEO & founder</p>
                                </div>
                            </div>
                            <!-- CAROUSEL ITEM 2 -->
                            <div class="carousel-item">
                                <!-- testimonials card  -->
                                <div class="testimonials__card">
                                    <p class="text-dark">
                                        <i class="fas fa-quote-left"></i>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Placeat aut consequatur illo animi optio exercitationem doloribus eligendi iusto
                                        atque repudiandae. Distinctio.
                                        <i class="fas fa-quote-right"></i>
                                    <div class="ratings p-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    </p>
                                </div>
                                <!-- client picture  -->
                                <div class="testimonials__picture">
                                    <img src="images/testimonials/client-2.jpg" alt="client-2 picture"
                                        class="rounded-circle img-fluid">
                                </div>
                                <!-- client name & role  -->
                                <div class="testimonials__name">
                                    <h3>Joy Marete</h3>
                                    <p class="fw-dark">Finance Manager</p>
                                </div>
                            </div>
                            <!-- CAROUSEL ITEM 3 -->
                            <div class="carousel-item">
                                <!-- testimonials card  -->
                                <div class="testimonials__card">
                                    <p class="text-dark">
                                        <i class="fas fa-quote-left"></i>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Placeat aut consequatur illo animi optio exercitationem doloribus eligendi iusto
                                        atque repudiandae. Distinctio.
                                        <i class="fas fa-quote-right"></i>
                                    <div class="ratings p-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    </p>
                                </div>
                                <!-- client picture  -->
                                <div class="testimonials__picture">
                                    <img src="images/testimonials/client-3.jpg" alt="client-3 picture"
                                        class="rounded-circle img-fluid">
                                </div>
                                <!-- client name & role  -->
                                <div class="testimonials__name">
                                    <h3>ClaireBelle Zawadi</h3>
                                    <p class="fw-dark">Global brand manager</p>
                                </div>
                            </div>
                            <!-- CAROUSEL ITEM 4 -->
                            <div class="carousel-item">
                                <!-- testimonials card  -->
                                <div class="testimonials__card">
                                    <p class="text-dark">
                                        <i class="fas fa-quote-left"></i>
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                        Placeat aut consequatur illo animi optio exercitationem doloribus eligendi iusto
                                        atque repudiandae. Distinctio.
                                        <i class="fas fa-quote-right"></i>
                                    <div class="ratings p-1">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    </p>
                                </div>
                                <!-- client picture  -->
                                <div class="testimonials__picture">
                                    <img src="images/testimonials/client-4.jpg" alt="client-4 picture"
                                        class="rounded-circle img-fluid">
                                </div>
                                <!-- client name & role  -->
                                <div class="testimonials__name">
                                    <h3>Uhuru Kenyatta</h3>
                                    <p class="fw-dark">C.E.O & Founder</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-outline-light fas fa-long-arrow-alt-left" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            </button>
                            <button class="btn btn-outline-light fas fa-long-arrow-alt-right" type="button"
                                data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            </button>
                        </div>
                    </div>
                </div> --}}
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#fff" fill-opacity="1"
          d="M0,96L48,128C96,160,192,224,288,213.3C384,203,480,117,576,117.3C672,117,768,203,864,202.7C960,203,1056,117,1152,117.3C1248,117,1344,203,1392,245.3L1440,288L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
        </path>
      </svg>
    </section>

    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////
                       START SECTION 6 - THE FAQ
//////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <section class="faq" id="faq">
      <div class="container">
        <div class="row text-center">
          <h1 class="display-3 fw-bold text-uppercase">faq</h1>
          <div class="heading-line"></div>
          <p class="lead">frequently asked questions, get knowledge befere hand</p>
        </div>
        <!-- ACCORDION CONTENT  -->
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="accordion" id="accordionExample">
              <!-- ACCORDION ITEM 1 -->
              <div class="accordion-item mb-3 shadow">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    type="button" aria-expanded="true" aria-controls="collapseOne">
                    What is ALmax?
                  </button>
                </h2>
                <div class="accordion-collapse show collapse" id="collapseOne" data-bs-parent="#accordionExample"
                  aria-labelledby="headingOne">
                  <div class="accordion-body">
                    ALmax is a technology-focused organization that aims to revolutionize the African market by
                    providing innovative
                    solutions, training, and support in various areas such as web design, development, automation, and
                    coaching.
                  </div>
                </div>
              </div>
              <!-- ACCORDION ITEM 2 -->
              <div class="accordion-item mb-3 shadow">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                    type="button" aria-expanded="false" aria-controls="collapseTwo">
                    What services does ALmax offer?
                  </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseTwo" data-bs-parent="#accordionExample"
                  aria-labelledby="headingTwo">
                  <div class="accordion-body">
                    ALmax offers a range of services including web design and development, software development,
                    automation solutions,
                    coaching and mentorship programs, training and skills development, and consultancy services in the
                    technology sector.
                  </div>
                </div>
              </div>
              <!-- ACCORDION ITEM 3 -->
              <div class="accordion-item mb-3 shadow">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" type="button" aria-expanded="false"
                    aria-controls="collapseThree">
                    How can I benefit from ALmax's services?
                  </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseThree" data-bs-parent="#accordionExample"
                  aria-labelledby="headingThree">
                  <div class="accordion-body">
                    By engaging with ALmax, you can access cutting-edge technology solutions, enhance your skills
                    through training programs,
                    receive guidance and coaching from industry experts, and gain valuable insights to help you succeed
                    in the digital
                    landscape.
                  </div>
                </div>
              </div>
              <!-- ACCORDION ITEM 4 -->
              <div class="accordion-item mb-3 shadow">
                <h2 class="accordion-header" id="headingFour">
                  <button class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour"
                    type="button" aria-expanded="false" aria-controls="collapseFour">
                    Who can avail ALmax's services?
                  </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapseFour" data-bs-parent="#accordionExample"
                  aria-labelledby="headingFour">
                  <div class="accordion-body">
                    ALmax caters to a wide range of individuals and organizations, including students, professionals,
                    businesses, NGOs, and
                    startups. Whether you are looking to enhance your skills, develop a website, automate processes, or
                    seek professional
                    guidance, ALmax can assist you.
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ///////////////////////////////////////////////////////////////////////////////////////////////////
                              START SECTION 7 - THE PORTFOLIO
//////////////////////////////////////////////////////////////////////////////////////////////////////-->

    {{-- <section id="portfolio" class="portfolio">
        <div class="container">
            <div class="row text-center mt-5">
                <h1 class="display-3 fw-bold text-capitalize">Latest work</h1>
                <div class="heading-line"></div>
                <p class="lead">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint porro temporibus distinctio.
                </p>
            </div>
            <!-- FILTER BUTTONS  -->
            <div class="row mt-5 mb-4 g-3 text-center">
                <div class="col-md-12">
                    <button class="btn btn-outline-primary" type="button">All</button>
                    <button class="btn btn-outline-primary" type="button">websites</button>
                    <button class="btn btn-outline-primary" type="button">design</button>
                    <button class="btn btn-outline-primary" type="button">mockup</button>
                </div>
            </div>

            <!-- START THE PORTFOLIO ITEMS  -->
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-box shadow">
                        <img src="images/portfolio/portfolio-2.jpg" alt="portfolio 2 image"
                            title="portfolio 2 picture" class="img-fluid">
                        <div class="portfolio-info">
                            <div class="caption">
                                <h4>project name goes here 2</h4>
                                <p>category project</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-box shadow">
                        <img src="images/portfolio/portfolio-3.jpg" alt="portfolio 3 image"
                            title="portfolio 3 picture" class="img-fluid">
                        <div class="portfolio-info">
                            <div class="caption">
                                <h4>project name goes here 3</h4>
                                <p>category project</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-box shadow">
                        <img src="images/portfolio/portfolio-4.jpg" alt="portfolio 4 image"
                            title="portfolio 4 picture" class="img-fluid">
                        <div class="portfolio-info">
                            <div class="caption">
                                <h4>project name goes here 4</h4>
                                <p>category project</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-box shadow">
                        <img src="images/portfolio/portfolio-5.jpg" alt="portfolio 5 image"
                            title="portfolio 5 picture" class="img-fluid">
                        <div class="portfolio-info">
                            <div class="caption">
                                <h4>project name goes here 5</h4>
                                <p>category project</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-box shadow">
                        <img src="images/portfolio/portfolio-6.jpg" alt="portfolio 6 image"
                            title="portfolio 6 picture" class="img-fluid">
                        <div class="portfolio-info">
                            <div class="caption">
                                <h4>project name goes here 6</h4>
                                <p>category project</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="portfolio-box shadow">
                        <img src="images/portfolio/portfolio-9.jpg" alt="portfolio 9 image"
                            title="portfolio 9 picture" class="img-fluid">
                        <div class="portfolio-info">
                            <div class="caption">
                                <h4>project name goes here 9</h4>
                                <p>category project</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
--}}
    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////
              START SECTION 8 - GET STARTED
/////////////////////////////////////////////////////////////////////////////////////////////////////////-->
    <section class="get-started" id="contact">
      <div class="container">
        <div class="row text-center">
          <h1 class="display-3 fw-bold text-capitalize">Get started</h1>
          <div class="heading-line"></div>
          <p class="text-dark">
            Code your dreams into reality!!!
          </p>
        </div>

        <!-- START THE CTA CONTENT  -->
        <div class="row text-white">
          <div class="col-12 col-lg-6 gradient p-3 shadow">
            <div class="cta-info w-100">
              <h4 class="display-4 fw-bold">100% Satisfaction Guaranteed</h4>
              <p class="text-dark">
                Let all your things have their places; let each part of your business have its time.
              </p>
              <h3 class="display-3--brief">What will be the next step?</h3>
              <ul class="cta-info__list">
                <li>Craft you innovation.</li>
                <li>we'll discuss it together.</li>
                <li>let's start the discussion.</li>
              </ul>
            </div>
          </div>
          <div class="col-12 col-lg-6 text-dark bg-white p-3 shadow">
            <livewire:app.card.project.requestForm />
          </div>
        </div>
      </div>
    </section>

    <!-- ///////////////////////////////////////////////////////////////////////////////////////////
                           START SECTION 9 - THE FOOTER
///////////////////////////////////////////////////////////////////////////////////////////////-->
    <livewire:footer />

    <!-- BACK TO TOP BUTTON  -->
    <a class="btn-primary rounded-circle back-to-top shadow" href="#" wire:navigate>
      <i class="fas fa-chevron-up"></i>
    </a>

    @livewireScripts
    <script src="{{ asset('build/assets/vendors/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <x-livewire-alert::scripts />
    <script src="{{ asset('build/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('build/assets/vendor/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="build/assets/vendors/js/glightbox.min.js"></script>

    <script type="text/javascript">
      const lightbox = GLightbox({
        'touchNavigation': true,
        'href': 'https://www.youtube.com/watch?v=J9lS14nM1xg',
        'type': 'video',
        'source': 'youtube', //vimeo, youtube or local
        'width': 900,
        'autoPlayVideos': 'true',
      });
    </script>
    <script src="build/assets/js/bootstrap.bundle.min.js"></script>
  </body>

</html>
