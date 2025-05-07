 <!-- Buy Tickets Section -->
 <section class="buy-tickets section light-background" id="buy-tickets">

   <!-- Section Title -->
   <div class="section-title container" data-aos="fade-up">
     <h2>Buy Tickets<br></h2>
     <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
   </div><!-- End Section Title -->

   <div class="container">
     @foreach ($events as $event)
       <div class="row gy-4 pricing-item featured mt-4" data-aos="fade-up" data-aos-delay="200">
         <div class="col-lg-3 d-flex align-items-center justify-content-center">
           <h3>{{ $event->title }}<br></h3>
         </div>
         <div class="col-lg-3 d-flex align-items-center justify-content-center">
           <h4><sup>NGN</sup>{{ $event->price }}<span> /
               ({{ $event->starting_day->diffForHumans($event->closing_day) }})
             </span></h4>
         </div>
         <div class="col-lg-3 d-flex align-items-center justify-content-center">
           {!! $event->description !!}
         </div>
         <div class="col-lg-3 d-flex align-items-center justify-content-center">
           <div class="text-center"><a class="buy-btn" href="#">Buy Now</a></div>
         </div>
       </div><!-- End Pricing Item -->
     @endforeach
   </div>

 </section><!-- /Buy Tickets Section -->
