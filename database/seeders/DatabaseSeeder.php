<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Client;
use App\Models\ClientCategory;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Models\UserClient;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->withPersonalTeam()->create();

        User::factory()->withPersonalTeam()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        UserClient::create([
            'user_id' => 1,
            'client_id' => 1,
        ]);
        ClientCategory::create([
            'title' => 'Software Develoment',
            'status' => 'active',
            'description' => 'Software develoment',
        ]);
        Client::create([
            'name' => 'ALmax Technology',
            'logo' => 'build/assets/almax-preview.png',
            'email' => 'alimustaphashettima@gmail.com',
            'tagline' => 'code your dreams into reality',
            'telephone' => '08166636567',
            'is_registered' => true,
            'is_verified' => true,
            'status' => 'active',
            'user_id' => 1,
            'category_id' => 1,
        ]);

        $Nigeria = Country::create([
            'name' => 'Nigeria',
            'code' => '234',
            'flag' => '🇳🇬',
            'iso2' => 'NG',
            'iso3' => 'NGA',
            'currency' => 'NGN',
            'status' => 'active',
        ]);
        $borno = State::create([
            'name' => 'Borno',
            'status' => 'active',
            'country_id' => $Nigeria->id
        ]);
        $maiduguri = City::create([
            'name' => 'Maiduguri',
            'postal_code' => '600282',
            'status' => 'active',
            'state_id' => $borno->id,
            'country_id' => $Nigeria->id
        ]);
        $baga = City::create([
            'name' => 'Baga',
            'postal_code' => '600282',
            'status' => 'active',
            'state_id' => $borno->id,
            'country_id' => $Nigeria->id
        ]);
        $Bama = City::create([
            'name' => 'Bama',
            'postal_code' => '600282',
            'status' => 'active',
            'state_id' => $borno->id,
            'country_id' => $Nigeria->id
        ]);
        $bauchi = State::create([
            'name' => 'Bauchi',
            'status' => 'active',
            'country_id' => $Nigeria->id
        ]);
        $bauchi_capital = City::create([
            'name' => 'Bauchi',
            'postal_code' => '600282',
            'status' => 'active',
            'state_id' => $bauchi->id,
            'country_id' => $Nigeria->id
        ]);
        $Azare = City::create([
            'name' => 'Azare',
            'postal_code' => '600282',
            'status' => 'active',
            'state_id' => $bauchi->id,
            'country_id' => $Nigeria->id
        ]);
        $Misau = City::create([
            'name' => 'Misau',
            'postal_code' => '600282',
            'status' => 'active',
            'state_id' => $bauchi->id,
            'country_id' => $Nigeria->id
        ]);
    }
}
