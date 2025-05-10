<div>
    <div class="form w-100 pb-2">
        <h4 class="display-3--title mb-5">start your project</h4>
        <form action="#" class="row" wire:submit.prevent="save">
            <div class="col-lg-6 col-md mb-3">
                <input type="text" placeholder="First Name" id="first_name" wire:model="first_name"
                    class="shadow form-control form-control-lg" required>
            </div>
            <div class="col-lg-6 col-md mb-3">
                <input type="text" placeholder="Last Name" id="last_name" wire:model="last_name"
                    class="shadow form-control form-control-lg" required>
            </div>
            <div class="col-lg-12 mb-3">
                <input type="email" placeholder="email address" id="email" wire:model="email"
                    class="shadow form-control form-control-lg" required>
            </div>
            <div class="col-lg-12 mb-3">
                <textarea name="message" placeholder="message" id="message" wire:model="message" rows="8"
                    class="shadow form-control form-control-lg" spellcheck="true" required></textarea>
            </div>
            <div class="text-center d-grid mt-1">
                <button type="submit" class="btn btn-primary rounded-pill pt-3 pb-3">
                    submit
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </form>
    </div>
</div>