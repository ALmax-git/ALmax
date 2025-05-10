<div class="container py-4">
  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Application Update</h5>
    </div>

    <div class="card-body">
      <button class="btn btn-outline-primary" wire:click="runUpdate" @if ($isProcessing) disabled @endif>
        @if ($isProcessing)
          <span class="spinner-border spinner-border-sm me-2"></span> Updating...
        @else
          <i class="bi bi-cloud-arrow-down"></i> Run Update
        @endif
      </button>

      @if ($output)
        <div class="mt-4">
          <h6>Output:</h6>
          <pre class="bg-light rounded border p-3" style="max-height: 300px; overflow-y: auto;">{{ $output }}</pre>
        </div>
      @endif
    </div>
  </div>
</div>
