<div class="container-fluid">
  <div class="row bg-secondary rounded">
    <div class="col-12">
      <div class="card bg-secondary mb-3 rounded">
        <div class="row g-0">
          <div class="col-md-4">
            <img class="card-img card-img-left"
              src="{{ $profile->profile_photo_path ? asset('storage/' . $profile->profile_photo_path) : asset('default.png') }}"
              alt="Card image" style="height:50vh; object-fit: cover;" />

            <div class="bg-secondary container rounded">
              <div class="row py-4 text-center">
                <div class="col-12">
                  Connect on social media
                </div>
                <div class="col-12">
                  <a href="#"> <i class="fab fa-facebook fa-2x"></i> </a>
                  <a href="#"> <i class="fab fa-twitter fa-2x"></i> </a>
                  <a href="#"> <i class="fab fa-github fa-2x"></i> </a>
                  <a href="#"> <i class="fab fa-linkedin fa-2x"></i> </a>
                  <a href="#"> <i class="fab fa-instagram fa-2x"></i> </a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card-body bg-secondary rounded">
              <div class="d-flex" style="justify-content: space-between;">
                <h5 class="card-title">{{ $profile->name }}</h5>
                <div>
                  <button class="btn btn-success" wire:click='employ'>Empower</a>
                </div>
              </div>
              <hr>
              <p><b>First Name: </b><i>{!! $profile->first_name ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>Surname: </b><i>{!! $profile->surname ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>Last Name: </b><i>{!! $profile->last_name ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>Gender: </b><i>{!! $profile->gender ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>Email: </b><i>{!! $profile->email ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>Phone Number: </b><i>{!! $profile->phone_number ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>Profession: </b><i>{!! $profile->profession ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>Address: </b><i>{!! $profile->address ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>State of Resident: </b><i>{!! $profile->state_of_resident ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <p><b>Nationality: </b><i>{!! $profile->nationality ?? '<span style="color:red;">Not set</span>' !!} </i></p>
              <hr>
              <small class="card-text">
                <!-- Display truncated bio -->
                <span x-data="{ showFullBio: false }">
                  <span x-show="!showFullBio">
                    {{ \Illuminate\Support\Str::limit($profile->bio, 150) }}
                    <!-- Limit to 150 characters or adjust as needed -->
                  </span>

                  <!-- Show full bio when toggled -->
                  <span x-show="showFullBio">
                    {{ $profile->bio }}
                  </span>

                  <!-- Toggle the full bio visibility -->
                  <a x-on:click="showFullBio = !showFullBio" wire:navigate>
                    <span style="color:green" x-show="!showFullBio">Read More</span>
                    <span style="color:orange" x-show="showFullBio">Show Less</span>
                  </a>
                </span>
              </small>

              <br>
              <a class="btn btn-sm btn-primary" href="javascript:;">Badges 4</a>
              <a class="btn btn-sm btn-outline-success" href="javascript:;">Like 2k</a>
              <a class="btn btn-sm btn-outline-primary" href="communities/{{ $profile->email }}" wire:navigate>View
                Profile</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
