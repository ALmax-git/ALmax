<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
// use Illuminate\Support\Facades\App;
use Livewire\Component;

class App extends Component
{
    use LivewireAlert;

    // Currently active tab on the dashboard
    public $tab = 'Dashboard';

    // Profile switcher visibility toggle
    public $switch_profile = false;

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

    public function mount()
    {
        // Optional: Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect to login if not authenticated
        }

        // Optional: Check if user has a client_id (business profile)
        if (!Auth::user()->client_id) {
            return redirect()->route('app.business.create'); // Redirect to business creation page
        }
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
