<div>

  <div class="card author-box border-primary">
    <div class="card-body border-primary" style="background-color: black ;">
      <div class="author-box-left position-relative">
        <img class="rounded-circle author-box-picture" src="{{ $user->profile_photo_url }}" alt="image">

        <div class="clearfix"></div>
        <a class="btn {{ $follower == 'follow' ? 'btn-outline-success' : 'btn-success' }} follow-btn mt-3" href="#"
          wire:click='toggle_follow'>{{ _app($follower) }}</a>
      </div>
      @if (!$white_paper_modal)
        <div class="author-box-details">
          <div class="author-box-name">
            <a href="#">{{ $user->name }}</a>
          </div>
          <div class="author-box-job">
            {{ $user->visibility == 'public' || $user->visibility == 'protected'
                ? $user->email ?? '⚠️ ' . _app('unverified')
                : ($user->email && $user->country
                    ? '***@**.*'
                    : '⚠️ ' . _app('unverified')) }}
          </div>
          <div class="author-box-job">
            {{ _app('followers') }}: <strong>{{ $user->followers->count() }}</strong> <br>
            {{ _app('clients') }}:
            <strong>{{ $user->clients->count() - 1 >= 0 ? $user->clients->count() : 0 }}</strong><br>
            {{ _app('@') }} <strong>{{ $user->client->name }}</strong>
          </div>
          <div class="author-box-description">
            <small class="card-text">
              <!-- Display truncated bio -->
              <span x-data="{ showFullBio: false }">
                <span x-show="!showFullBio">
                  {{ \Illuminate\Support\Str::limit($user->bio, 150) }}
                  <!-- Limit to 150 characters or adjust as needed -->
                </span>

                <!-- Show full bio when toggled -->
                <span x-show="showFullBio">
                  {{ $user->bio }}
                </span>

                <!-- Toggle the full bio visibility -->
                <a x-on:click="showFullBio = !showFullBio" wire:navigate>
                  <span style="color:green" x-show="!showFullBio">Read More</span>
                  <span style="color:orange" x-show="showFullBio">Show Less</span>
                </a>
              </span>
            </small>
          </div>
          <div class="mb-2 mt-3">
            @if ($user->city && $user->state && $user->country && $user->phone_number)
              <div class="text-small font-weight-bold text-success">{{ _app('verified') }}</div>
              @if ($user->visibility == 'public')
                <hr>
                <p><b>First Name: </b><i>{!! $user->first_name ?? '<span style="color:red;">Not set</span>' !!} </i></p>
                <p><b>Surname: </b><i>{!! $user->surname ?? '<span style="color:red;">Not set</span>' !!} </i></p>
                <p><b>Last Name: </b><i>{!! $user->last_name ?? '<span style="color:red;">Not set</span>' !!} </i></p>
                <p><b>Gender: </b><i>{!! $user->gender ?? '<span style="color:red;">Not set</span>' !!} </i></p>
                <p><b>Email: </b><i>{!! $user->email ?? '<span style="color:red;">Not set</span>' !!} </i></p>
                <p><b>Phone Number: </b><i>{!! $user->phone_number ?? '<span style="color:red;">Not set</span>' !!} </i></p>
                <hr>
                {{ $user->country->flag }} {{ $user->country->name }} <br>
                {{ $user->state->name }}, {{ $user->city->name }} <br>
                {{ $user->email }} <br>
                {{ $user->phone_number }}
              @endif
              <button class="btn btn-outiline-success rounded-pill"></button>
            @else
              <div class="text-small font-weight-bold text-warning">{{ _app('unverified') }}</div>
            @endif
          </div>

          <div class="w-100 d-sm-none"></div>
          @if (user_can_access('staff_management'))
            <div class="mt-sm-0 float-right mt-3">
              <a class="btn" href="#">Work with {{ $user->name }} @ {{ Auth::user()->client->name }}! Click
                the
                Right arrow.
                <button class="btn btn-sm btn-outline-primary" wire:click='init_white_paper'>
                  <i class="bi bi-arrow-right"></i>
                </button>
              </a>
            </div>
          @endif
        </div>
      @else
        <div class="modal-body">
          <h3 class="text-primary text-center">{{ $user->name }}</h3>
          <label for="title">{{ _app('title') }}</label>
          <input class="form-control" type="text" wire:model.live="title" placeholder="Title of your offer">
          @error($title)
            <span>{{ $message }}</span>
          @enderror

          <label for="white_paper_text">{{ _app('White_paper') }}</label>
          <textarea class="form-control" type="text" wire:model.live="white_paper_text"></textarea>
          @error($white_paper_text)
            <span>{{ $message }}</span>
          @enderror
          <label for="password">{{ _app('password') }}</label>
          <input class="form-control" type="password" wire:model.live="password"
            placeholder="Enter your password to confirm Action">
          @error($password)
            <span>{{ $message }}</span>
          @enderror
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button"
            wire:click="cancel_white_paper">{{ _app('cancel') }}</button>
          <button class="btn btn-danger" type="button" wire:click="sign_white_paper">{{ _app('Sign_Paper') }}</button>
        </div>
      @endif
    </div>
  </div>
</div>
