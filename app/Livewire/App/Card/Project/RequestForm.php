<?php

namespace App\Livewire\Card\Project;

use App\Models\project_request_form;
use Illuminate\Support\Facades\Http;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RequestForm extends Component
{
    use LivewireAlert;
    public $first_name;
    public $last_name;
    public $email;
    public $message;

    public $device;
    public $user_agent;
    public $ip;
    public $longitude;
    public $latitude;
    public $timezone;
    public $country;
    public $state;
    public $city;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'message' => 'required|string',
    ];

    public function mount()
    {
        $this->getDeviceAndLocationData();
    }
    public function getDeviceAndLocationData()
    {
        // Get the user's IP
        $ip = request()->ip();

        // Check if we are on localhost (127.0.0.1)
        if ($ip === '127.0.0.1' || $ip === '::1') {
            // For local development, you can set a default IP or use a mock IP address
            // Example: Using a hardcoded public IP for testing purposes
            $ip = '8.8.8.8';  // Example of a public IP (Google's DNS server)
        }

        $this->ip = $ip;

        // Get device information (User-Agent)
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->user_agent = $userAgent;

        // Get timezone using PHP
        $timezone = timezone_name_from_abbr("", date("Z"), false);
        $this->timezone = $timezone;

        // Get the location data using cURL (replace with your actual API)
        $this->getGeolocationData($ip);
    }


    public function getGeolocationData($ip)
    {
        // Replace with your IP geolocation API key (e.g., from ipinfo.io or any other service)
        $apiKey = env('GEOLOCATION_API_KEY'); // Example API key from ipinfo.io or another service
        $url = "http://ipinfo.io/{$ip}/json?token={$apiKey}";

        // Use cURL to get the geolocation data
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            // Handle the error (maybe log it)
            $this->country = $this->state = $this->city = 'Unknown';
            $this->longitude = $this->latitude = '';
            return;
        }

        // Close cURL session
        curl_close($ch);

        // Decode the response JSON
        $locationData = [];
        $locationData = json_decode($response, true);

        // Assign values from the API response
        $this->country = $locationData['country'] ?? '';
        $this->state = $locationData['region'] ?? '';
        $this->city = $locationData['city'] ?? '';
        $this->longitude = explode(',', $locationData['loc'] ?? ['null'])[0] ?? '';
        $this->latitude = explode(',', $locationData['loc'] ?? ['null'])[1] ?? '';
    }



    public function save()
    {
        $this->validate();
        project_request_form::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'message' => $this->message,
            'device' => $this->device,
            'user_agent' => $this->user_agent,
            'ip' => $this->ip,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'timezone' => $this->timezone,
            'country' => $this->country,
            'state' => $this->state,
            'city' => $this->city,
        ]);

        $this->alert('success', 'Your request has been submitted successfully!');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.card.project.request-form');
    }
}
