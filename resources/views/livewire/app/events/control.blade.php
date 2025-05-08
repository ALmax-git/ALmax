 <!-- Buy Tickets Section -->
 <section class="buy-tickets section light-background" id="buy-tickets">

   <!-- Section Title -->
   <div class="section-title container" data-aos="fade-up">
     <h2>🎟️ Buy Tickets<br></h2>
     <p>Secure your spot at the International Conference on Flood Management 2025 — where action meets awareness.</p>
   </div><!-- End Section Title -->
   @if ($ticket_modal)
     <div class="modal" tabindex="999" style="display:block;" style="z-index: 9999">
       <div class="modal-dialog">
         <div class="modal-content">
           <div class="modal-header d-flex align-items-center justify-content-between">
             <h5 class="modal-title">{{ _app('buy_ticket') }}</h5>
             <button class="close" type="button" wire:click="close_buy_ticket">
               <span>&times;</span>
             </button>
           </div>
           <div class="modal-body scrollable scroll">
             <h1>{{ $event->title }}</h1>

             <p>
               {{ \Carbon\Carbon::parse($event->starting_day)->format('jS M Y') }}
               to
               {{ \Carbon\Carbon::parse($event->closing_day)->format('jS M Y') }}
             </p>
             <p>
               {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
               to
               {{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}
             </p>
             <div>
               {!! $event->description !!}
             </div>
             <h2>{{ $event->price }} </h2>
           </div>
           <div class="modal-footer">
             <button class="btn btn-secondary" type="button"
               wire:click="close_buy_ticket">{{ _app('cancel') }}</button>
             <form action="{{ route('new_ticket') }}" method="post">
               @csrf
               <input name="event_id" type="hidden" value="{{ $id }}">
               <input name="tx_ref" type="hidden" value="{{ $tx_ref }}">
               <button class="btn btn-primary" type="submit">{{ _app('buy_ticket') }}</button>
             </form>
           </div>
         </div>
       </div>
     </div>
   @endif
   <div class="container">
     @foreach ($events as $event)
       <div class="row gy-4 pricing-item featured mt-4" data-aos="fade-up" data-aos-delay="100">
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
           <div class="text-center"><a class="buy-btn" wire:click='buy_ticket("{{ write($event->id) }}")'>Buy Now</a>
           </div>
         </div>
       </div><!-- End Pricing Item -->
     @endforeach
   </div>

 </section><!-- /Buy Tickets Section -->
