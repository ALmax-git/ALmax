<div>
  <div class="row mb-2">
    {{-- <h6 class="mb-4">{{ _app('system_role_and_permission') }}</h6> --}}
    <div class="col">
      <input class="form-control" type="text" wire:model.live="search" autocomplete="search" autofocus spellcheck=""
        placeholder=" 🔍 {{ _app('search') }}">
    </div>
    <div class="col">
      <button class="btn btn-sm btn-outline-primary float-end ms-2" wire:click='open_role_modal'><i
          class="bi bi-plus"></i>{{ 'role' }}</button>
      <button class="btn btn-sm btn-outline-primary float-end ms-2" wire:click='open_permission_modal'><i
          class="bi bi-plus"></i>{{ 'permission' }}</button>
    </div>
  </div>
  @if ($role_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pl"></i>{{ _app('role') }}</h5>
            <button class="close" type="button" wire:click="close_role_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @if ($is_edit)
              <h3 class="text-primary text-center">{{ $role->title }}</h3>
            @endif
            <label for="title">{{ _app('title') }}</label>
            <input class="form-control" type="text" wire:model.live="title" placeholder="{{ _app('title') }}">
            @error($title)
              <span>{{ $message }}</span>
            @enderror

            <label for="description">{{ _app('description') }}</label>
            <textarea class="form-control" type="text" wire:model.live="description" placeholder="{{ _app('description') }}"></textarea>
            @error($description)
              <span>{{ $message }}</span>
            @enderror

            <label class="form-label" for="status">{{ _app('status') }}</label>
            <select class="form-control" id="status" name="status" wire:model.live='status'>
              <option value="">{{ _app('choose') }}</option>
              <option value="active">{{ _app('active') }}</option>
              {{-- <option value="archived">{{ _app('archived') }}</option> --}}
              <option value="deactivated">{{ _app('deactivated') }}</option>
            </select>
            @error($status)
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_role_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="save_role">{{ _app('Save') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($role_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
            <button class="close" type="button" wire:click="cancel_role_delete">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $role->title }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="cancel_role_delete">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="confirm_delete_role"><i
                class="bi bi-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($add_permission_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <button class="close" type="button" wire:click="cancel_add_permission">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $role->title }}</h3>

            <label class="form-label" for="permission_id">{{ _app('permission') }}</label>
            <select class="form-control" id="permission_id" wire:model.live='permission_id'>
              <option value="">{{ _app('choose') }}</option>
              @foreach (\App\Models\Permission::orderBy('title')->get() as $Permission)
                <option value="{{ $Permission->id }}">{{ $Permission->title }} </option>
              @endforeach
            </select>
            @error($permission_id)
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="cancel_add_permission">{{ _app('cancel') }}</button>
            <button class="btn btn-primary" type="button"
              wire:click="create_role_permission">{{ _app('save') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="table-responsive">
    <table class="table-striped table-hover table-sm table">
      <thead class="table-dark">
        <tr>
          <th>{{ _app('Role') }}</th>
          <th>{{ _app('description') }}</th>
          <th>{{ _app('permissions') }}</th>
          <th>{{ _app('status') }}</th>
          <th style="text-align: end;">{{ _app('action') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($roles as $Role)
          <tr>
            <td>{{ $Role->title }}</td>
            <td>{{ $Role->description }}</td>
            <td>
              <div class="row">
                @foreach ($Role->permissions as $Permission)
                  <span class="badge bg-info m-2" style="width: min-content;">
                    <i class="bi bi-trash" style="color: red !important; cursor: pointer;"
                      wire:click='remove_permission("{{ write($Role->id) }}", "{{ write($Permission->id) }}")'></i>
                    {{ $Permission->title }}
                  </span>
                @endforeach
              </div>
            </td>
            <td>{{ _app($Role->status) }}</td>
            <td style="width: 10vw;" style="text-align: end;">
              <button class="btn btn-sm btn-outline-success" wire:click='add_permission("{{ write($Role->id) }}")'><i
                  class="bi bi-plus"></i>{{ _app('access') }} </button>
              <button class="btn btn-sm btn-info" wire:click='edit_role("{{ write($Role->id) }}")'>
                <i class="bi bi-pen"></i></button>
              <button class="btn btn-sm btn-danger" wire:click='delete_role("{{ write($Role->id) }}")'>
                <i class="bi bi-trash"></i></button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $roles->links() }}
  </div>

  <hr>
  @if ($permission_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title"><i class="bi bi-pl"></i>{{ _app('permission') }}</h5>
            <button class="close" type="button" wire:click="close_permission_modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            @if ($is_edit)
              <h3 class="text-primary text-center">{{ $permission->title }}</h3>
            @endif
            <label for="title">{{ _app('title') }}</label>
            <input class="form-control" type="text" wire:model.live="title" placeholder="{{ _app('title') }}">
            @error($title)
              <span>{{ $message }}</span>
            @enderror

            <label for="label">{{ _app('access') }}</label>
            <input class="form-control" type="text" wire:model.live="label" placeholder="{{ _app('access') }}">
            @error($label)
              <span>{{ $message }}</span>
            @enderror

            <label for="description">{{ _app('description') }}</label>
            <textarea class="form-control" type="text" wire:model.live="description"
              placeholder="{{ _app('description') }}"></textarea>
            @error($description)
              <span>{{ $message }}</span>
            @enderror

            <label class="form-label" for="status">{{ _app('status') }}</label>
            <select class="form-control" id="status" name="status" wire:model.live='status'>
              <option value="">{{ _app('choose') }}</option>
              <option value="active">{{ _app('active') }}</option>
              {{-- <option value="archived">{{ _app('archived') }}</option> --}}
              <option value="deactivated">{{ _app('deactivated') }}</option>
            </select>
            @error($status)
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="close_permission_modal">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="save_permission">{{ _app('Save') }}</button>
          </div>
        </div>
      </div>
    </div>
  @endif
  @if ($permission_delete_modal)
    <div class="modal" tabindex="-1" style="display:block;">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title">{{ _app('confirm_deletion') }}</h5>
            <button class="close" type="button" wire:click="cancel_permission_delete">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>{{ _app('msg_delete') }}?</p>
            <h3 class="text-primary text-center">{{ $permission->title }}</h3>
            <input class="form-control" type="password" wire:model.live="password"
              placeholder="Enter your password to confirm">
            @error($password)
              <span>{{ $message }}</span>
            @enderror
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button"
              wire:click="cancel_permission_delete">{{ _app('cancel') }}</button>
            <button class="btn btn-danger" type="button" wire:click="confirm_delete_permission"><i
                class="bi bi-trash"></i></button>
          </div>
        </div>
      </div>
    </div>
  @endif
  <div class="table-responsive">
    <table class="table-striped table-hover table-sm table">
      <thead class="table-dark">
        <tr>
          <th>{{ _app('Permission') }}</th>
          <th>{{ _app('Access') }}</th>
          <th>{{ _app('description') }}</th>
          <th>{{ _app('Roles') }}</th>
          <th>{{ _app('status') }}</th>
          <th style="text-align: end;">{{ _app('action') }}</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($permissions as $Permission)
          <tr>
            <td>{{ $Permission->title }}</td>
            <td><span class="badge bg-info">{{ $Permission->label }}</span></td>
            <td>{{ $Permission->description }}</td>
            <td>{{ $Permission->roles->count() }}</td>
            <td>{{ _app($Permission->status) }}</td>
            <td style="text-align: end;">
              <button class="btn btn-sm btn-info" wire:click='edit_permission("{{ write($Permission->id) }}")'><i
                  class="bi bi-pen"></i></button>
              <button class="btn btn-sm btn-danger" wire:click='delete_permission("{{ write($Permission->id) }}")'><i
                  class="bi bi-trash"></i></button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    {{ $permissions->links() }}
  </div>
</div>
