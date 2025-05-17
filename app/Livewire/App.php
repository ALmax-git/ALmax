<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\Empowerment;
use App\Models\Event;
use App\Models\EventTicket;
use App\Models\User;
use App\Models\UserClient;
use App\Models\Wallet;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
// use Illuminate\Support\Facades\App;
use Livewire\Component;

class App extends Component
{
    use LivewireAlert;

    // Currently active tab on the dashboard
    public $tab = '';

    //toggle wallet modal
    public $view_wallet = false;
    public $client_wallet_modal = false;

    // Profile switcher visibility toggle
    public $switch_profile = false;

    //User Wallet
    public ?Wallet $wallet, $client_wallet;

    public $event_ticket_modal = false;
    public $event_ticket = null;

    public $email, $model;



    public $events = [];
    public $event;
    public $ticket_modal = false;
    public $tx_ref, $id;

    public function buy_ticket($id): void
    {
        // dd($this);
        $this->event = Event::find(read($id));
        $this->ticket_modal = true;
        $this->tx_ref = generate_tx_ref();
        $this->id = write($this->event->id);
    }
    public function close_buy_ticket(): void
    {
        $this->ticket_modal = false;
    }

    public function view_ticket($id)
    {
        $this->event_ticket = EventTicket::find(read($id));
        if (!$this->event_ticket) {
            $this->alert('error', 'Event ticket not found');
            return;
        }
        $this->event_ticket_modal = true;
    }
    public function close_event_ticket()
    {
        $this->event_ticket = null;
        $this->event_ticket_modal = false;
    }

    public function open_client_wallet(): void
    {
        $this->client_wallet_modal = true;
    }
    public function close_client_wallet(): void
    {
        $this->client_wallet_modal = false;
    }
    public function open_wallet(): void
    {
        $this->view_wallet = true;
    }
    public function close_wallet(): void
    {
        $this->view_wallet = false;
    }
    /**
     * Logs the user out and redirects to login page.
     */
    public function logout()
    {
        Auth::logout(); // Safely log out current user
        return redirect()->route('login'); // Redirect to login route
    }

    /**
     * Attempts to close the app by terminating processes:
     * - Firefox (browser)
     * - PHP (artisan serve or Laravel server)
     */
    public function closeApp()
    {
        $os = strtoupper(substr(PHP_OS, 0, 3)); // Detect OS type (WIN for Windows)

        if ($os === 'WIN') {
            exec('taskkill /F /IM firefox.exe'); // Kill Firefox on Windows
            exec('taskkill /F /IM php.exe');     // Kill PHP/Laravel dev server
        } else {
            exec('pkill firefox'); // Kill Firefox on Linux/macOS
            exec('pkill php');     // Kill PHP dev server
        }
    }

    /**
     * Toggles the profile switch modal.
     */
    public function toggle_profile_model()
    {
        $this->switch_profile = !$this->switch_profile;
    }

    /**
     * Switch the active business profile of the logged-in user.
     *
     * @param int|string $id - The ID of the client to switch to
     */
    public function switch_profiles($id)
    {
        $client = Client::find(read($id)); // Use custom `read()` helper if decoding/encrypting
        if (!$client) {
            $this->alert('error', 'Client not found.');
            return;
        }

        $user = Auth::user();
        $user->update([
            'client_id' => $client->id
        ]);

        $this->alert('success', "Switched to {$client->name}");
        return redirect()->route('app');
    }

    /**
     * Switches between UI tabs.
     *
     * @param string $tab
     */
    public function change_tab($tab)
    {
        $this->tab = $tab;
    }

    public function mount($model = '', $email = null)
    {
        if ($model) {
            switch ($model) {
                case 'User':
                    if ($email) {
                        $this->tab = 'Community';
                        $this->email = $email;
                    } else {
                        $this->tab = 'Dashboard';
                    }
                    break;

                default:
                    $this->tab = 'Dashboard';
                    break;
            }
        } else {
            $this->tab = 'Dashboard';
        }
        // Optional: Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        // Optional: Check if user has a client_id (business profile)
        // if (!Auth::user()->client_id) {
        //     return redirect()->route('app.business.create'); // Redirect to business creation page
        // }
        //Set Language
        $locale = 'en'; // Default language
        if (Auth::user()->language) {
            switch (Auth::user()->language) {
                case 'English':
                    $locale = 'en';
                    break;
                case 'Arabic':
                    $locale = 'ar';
                    break;
                case 'French':
                    $locale = 'fr';
                    break;
                case 'Spannish':
                    $locale = 'es';
                    break;

                default:
                    $locale = 'en';
                    break;
            }
        }

        FacadesApp::setLocale($locale);
        if (!Auth::user()->client_id) {
            $user = User::find(Auth::user()->id);
            $user->client_id = 1;
            $user->save();
            UserClient::create([
                'user_id' => $user->id,
                'client_id' => $user->client_id,
                'is_staff' => false
            ]);
            return redirect()->route('app');
        }
        $this->wallet = Wallet::where('user_id', Auth::user()->id)->where('type', 'user')->first();
        if (!$this->wallet) {
            $this->wallet = new Wallet();
            $this->wallet->user_id = Auth::user()->id;
            $this->wallet->address = generate_wallet_address(Auth::user()->id);
            $this->wallet->balance = 0.00;
            $this->wallet->label = "My Wallet";
            $this->wallet->type = 'user';
            $this->wallet->save();
        }

        if (user_can_access('client_wallet_access')) {
            $this->client_wallet = Wallet::where('user_id', Auth::user()->client_id)->where('type', 'client')->first();
            if (!$this->client_wallet) {
                $this->client_wallet = new Wallet();
                $this->client_wallet->user_id = Auth::user()->client_id;
                $this->client_wallet->address = generate_wallet_address(Auth::user()->client_id);
                $this->client_wallet->balance = 0.00;
                $this->client_wallet->label = "My Business Wallet";
                $this->client_wallet->type = 'client';
                $this->client_wallet->save();
            }
        }

        if (Auth::user()->white_papers->count() > 0) {
            $this->alert(
                'info',
                Auth::user()->name . ' you have ' . Auth::user()->white_papers->count() . ' White papers. this may be a new oppotunity!',
                [
                    'position' => 'center',
                    'toast' => 1,
                    'showConfirmButton' => true,
                    'timer' => null
                ]
            );
        }

        $this->events = Event::orderBy('created_at', 'desc')->where('status', 'confirmed')->get();
    }
    public function refresh()
    {
        $this->mount();
    }
    public function reload()
    {
        return redirect()->route('app');
    }
    public function accept_white_paper($id)
    {
        $white_paper = Empowerment::find(read($id));
        if ($white_paper) {
            $white_paper->status = 'accepted';
            $white_paper->save();
            $user_client = UserClient::where('user_id', Auth::user()->id)
                ->where('client_id', $white_paper->client->id)->first();
            if ($user_client) {
                $user_client->is_staff = true;
                $user_client->save();
            } else {
                UserClient::create([
                    'user_id' => Auth::user()->id,
                    'is_staff' => true,
                    'client_id' => $white_paper->client->id
                ]);
            }
            $this->alert('success', 'White paper accepted successfully');
        } else {
            $this->alert('error', 'White paper not found');
        }
    }
    public function decline_white_paper($id)
    {
        $white_paper = Empowerment::find(read($id));
        if ($white_paper) {
            $white_paper->status = 'rejected';
            $white_paper->save();
            $this->alert('success', 'White paper rejected successfully');
        } else {
            $this->alert('error', 'White paper not found');
        }
    }
    public function placeholder()
    {
        return <<<'HTML'
                            <div class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center" id="spinner">
                                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div> 
        HTML;
    }
    /**
     * Render the main app dashboard and track usage.
     */
    public function render()
    {
        // Optional: Custom helper to log user actions, e.g., IP/location/browser/etc.
        \App\helpers\RequestTracker::track();
        // Return main Livewire view
        // $this->alert('info', _app("welcome") . ' ' . Auth::user()->name); // Optional: Alert on load
        return view('livewire.app');
    }
}
