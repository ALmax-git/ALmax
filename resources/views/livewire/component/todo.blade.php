<div class="container-fluid pt-4" style="min-height: 80vh;">

  <div class="h-100 bg-secondary rounded p-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h6 class="mb-0">{{ _app('todo') }}</h6>
      {{-- <a href="#">Show All</a> --}}
    </div>

    <div class="d-flex mb-2">
      <input class="form-control me-2 bg-transparent" type="text" wire:model.live="search"
        placeholder="{{ _app('search_task') }}">
      <select class="form-select me-2 bg-transparent" wire:model.live="priority">
        <option value="">{{ _app('all_priorities') }}</option>
        <option value="low">{{ _app('low') }}</option>
        <option value="medium">{{ _app('Medium') }}</option>
        <option value="high">{{ _app('High') }}</option>
      </select>
      <button class="btn btn-primary" wire:click="open_model">{{ _app('Add') }}</button>
    </div>
    @if ($model)
      <div class="mb-3">
        <input class="form-control bg-transparent" type="text" wire:model="task" placeholder="{{ _app('title') }}">
        <textarea class="form-control mt-2 bg-transparent" wire:model="description" placeholder="{{ _app('description') }}"></textarea>
        <input class="form-control mt-2 bg-transparent" type="date" wire:model="due_date">
        <select class="form-select mt-2 bg-transparent" wire:model.live="priority">
          <option value="">{{ _app('choose') }}</option>
          <option value="low">{{ _app('Low') }}</option>
          <option value="medium" selected>{{ _app('Medium') }}</option>
          <option value="high">{{ _app('High') }}</option>
        </select>
        <button class="btn btn-primary mt-2" wire:click="{{ $editId ? 'updateTask' : 'addTask' }}">
          {{ $editId ? _app('update_task') : _app('add_task') }}
        </button>
        <button class="btn btn-primary mt-2" wire:click="close_model">
          {{ _app('Cancel') }}
        </button>
      </div>
    @endif
    <div class="table-responsive">

      <table class="table-striped table-hover table-sm table">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th style="width: 10vw;">{{ _app('title') }}</th>
            <th style="width: 35vw;">{{ _app('description') }}</th>
            <th>{{ _app('due_date') }}</th>
            <th>{{ _app('Priority') }}</th>
            <th>{{ _app('Status') }}</th>
            <th style="text-align: right;">{{ _app('Actions') }}</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($tasks as $index => $task)
            <tr>
              <td>
                {{ $loop->iteration }}
              </td>
              <td class="{{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $task->title }}
              </td>
              <td class="{{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $task->description }}
              </td>
              <td class="{{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $task->due_date }}
              </td>
              <td>
                <span
                  class="badge {{ $task->priority === 'high' ? 'bg-danger' : ($task->priority === 'medium' ? 'bg-warning' : 'bg-success') }}">
                  {{ _app(ucfirst($task->priority)) }}
                </span>
              </td>
              <td>
                <span class="badge {{ $task->status === 'completed' ? 'bg-success' : 'bg-secondary' }}">
                  {{ _app($task->status) }}
                </span>
              </td>
              <td style="text-align: right;">
                <input class="form-check-input btn btn-outline-primary m-1" type="checkbox"
                  style="width: 12px; height: 12px;" wire:click="toggleStatus({{ $task->id }})"
                  {{ $task->status === 'completed' ? 'checked' : '' }}>
                <button class="btn btn-sm btn-outline-primary" wire:click="editTask({{ $task->id }})">
                  <i class="bi bi-pen"></i>
                </button>
                <button class="btn btn-sm btn-outline-danger" wire:click="deleteTask({{ $task->id }})">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td class="text-muted text-center" colspan="7">No tasks found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{-- {{ $tasks->links() }} --}}
    </div>

  </div>
</div>
