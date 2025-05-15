  <div class="container-fluid px-4 pt-4">
    @if (user_can_access('business_settings'))
      <div class="bg-secondary rounded-top mt-2 p-4">
        <h4>{{ Auth::user()->client->name }} {{ _app('staffs Management') }}</h4>

        @if ($add_role_modal && user_can_access('role_management'))
          <div class="modal" tabindex="-1" style="display:block;">
            <div class="modal-dialog">
              <div class="modal-content bg-secondary">
                <div class="modal-header">
                  <button class="close" type="button" wire:click="cancel_add_role">
                    <span>&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>{{ _app('msg_delete') }}?</p>
                  <h3 class="text-primary text-center">{{ $staff->name }}</h3>

                  <label class="form-label" for="role_id">{{ _app('Role') }}</label>
                  <select class="form-control" id="role_id" wire:model.live='role_id'>
                    <option value="">{{ _app('choose') }}</option>
                    @foreach ($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->title }} </option>
                    @endforeach
                  </select>
                  @error($role_id)
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button"
                    wire:click="cancel_add_role">{{ _app('cancel') }}</button>
                  <button class="btn btn-primary" type="button"
                    wire:click="create_user_role">{{ _app('save') }}</button>
                </div>
              </div>
            </div>
          </div>
        @endif

        @if (
            $remove_staff_modal &&
                (user_can_access('role_management') || user_can_access('staff_management')) &&
                !($user->id == $user->client->user_id))
          <div class="modal" tabindex="-1" style="display:block;">
            <div class="modal-dialog">
              <div class="modal-content bg-secondary">
                <div class="modal-header">
                  <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
                  <button class="close" type="button" wire:click="cancel_remove_staff">
                    <span>&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>{{ _app('msg_delete') }}?</p>
                  <h3 class="text-primary text-center">{{ $staff->name }}</h3>
                  <input class="form-control" type="password" wire:model.live="password"
                    placeholder="Enter your password to confirm">
                  @error($password)
                    <span>{{ $message }}</span>
                  @enderror
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button"
                    wire:click="cancel_remove_staff">{{ _app('cancel') }}</button>
                  <button class="btn btn-danger" type="button"
                    wire:click="confirm_remove_staff">{{ _app('remove') }}</button>
                </div>
              </div>
            </div>
          </div>
        @endif
        @if ($profile_modal)
          <div class="modal" tabindex="-1" style="display:block;">
            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-center">
              <div class="modal-content bg-secondary">
                <div class="modal-header">
                  <button class="close btn btn-secondary" type="button" wire:click="close_profile">
                    <span>&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  @livewire('app.card.profile', ['id' => write($profile->id)])
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button"
                    wire:click="close_profile">{{ _app('close') }}</button>
                </div>
              </div>
            </div>
          </div>
        @endif
        @if (user_can_access('view_staff'))
          <div class="table-responsive">
            <table class="table-striped table-hover table-sm table">
              <thead class="table-dark">
                <tr>
                  <th>#</th>
                  <th>{{ _app('Photo') }}</th>
                  <th>{{ _app('username') }}</th>
                  <th>{{ _app('email') }}</th>
                  <th>{{ _app('phone_number') }}</th>
                  <th>{{ _app('language') }}</th>
                  <th>{{ _app('city') }}</th>
                  <th>{{ _app('role') }}</th>
                  <th style="text-align: end;">{{ _app('action') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($staffs as $user)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                      <img class="rounded-circle me-lg-2"
                        src="{{ $user->profile_photo_path ? 'storage/' . $user->profile_photo_path : 'default.png' }}"
                        alt="" style="width: 30px; height: 30px;">
                    </td>
                    <td>{{ $user->country->flag ?? '⚠️' }} {{ $user->name }}</td>
                    <td>
                      {{ $user->visibility == 'public' || $user->visibility == 'protected'
                          ? $user->email ?? '⚠️ ' . _app('unverified')
                          : ($user->email && $user->country
                              ? '***@**.*'
                              : '⚠️ ' . _app('unverified')) }}
                    </td>
                    <td>
                      {{ $user->visibility == 'public' || $user->visibility == 'protected'
                          ? $user->phone_number ?? '⚠️ ' . _app('unverified')
                          : ($user->phone_number && $user->country
                              ? $user->country->code . '*****'
                              : '⚠️ ' . _app('unverified')) }}
                    </td>
                    <td>{{ $user->language ?? '⚠️ ' . _app('unverified') }}</td>
                    <td>{{ $user->city->name ?? '⚠️ ' . _app('unverified') }}</td>
                    <td>
                      <div class="row">
                        @foreach ($user->roles as $role)
                          <span class="badge bg-info m-2" style="width: min-content;">

                            @if (
                                (user_can_access('role_management') || user_can_access('staff_management')) &&
                                    !($user->id == $user->client->user_id))
                              <i class="bi bi-trash" style="color: red !important; cursor: pointer;"
                                wire:click='remove_role("{{ write($role->id) }}", "{{ write($user->id) }}")'></i>
                            @endif

                            {{ $role->title }}
                          </span>
                        @endforeach
                      </div>
                    </td>
                    <td style="width: 10vw;" style="text-align: end;">

                      <button class="btn btn-sm btn-outline-info"
                        wire:click='view_profile("{{ write($user->id) }}")'><i class="bi bi-eye"></i></button>

                      @if (
                          (user_can_access('role_management') || user_can_access('staff_management')) &&
                              !($user->id == $user->client->user_id))
                        <button class="btn btn-sm btn-outline-success"
                          wire:click='add_role("{{ write($user->id) }}")'><i
                            class="bi bi-plus"></i>{{ _app('role') }} </button>
                      @endif

                      @if (user_can_access('staff_management') && !($user->id == $user->client->user_id))
                        <button class="btn btn-sm btn-danger" wire:click='remove_staff("{{ write($user->id) }}")'>
                          <i class="bi bi-trash"></i></button>
                      @endif

                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            {{ $staffs->links() }}
          </div>
        @endif
      </div>
    @endif
  </div>
