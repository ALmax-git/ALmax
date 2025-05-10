<div>
    <h6 class="mb-2">Your adventure starts here 🚀</h6>
    <form id="formAuthentication" wire:submit.prevent='open_gate' class="mb-3">
        @csrf
        <div class="mb-3">
            {{-- <label for="email" class="form-label">Email</label> --}}
            <input type="email" class="form-control" id="email" wire:model='email' required
                placeholder="Enter your email" autocomplete="email" autofocus />
        </div>
        <button type="submit" class="btn btn-primary d-grid w-100">Continue to ALmax</button>
    </form>
    <div class="text-center">
        <a href="/" class="d-flex align-items-center justify-content-center">
            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
            Back to home
        </a>
    </div>
</div>