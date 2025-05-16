<?php

use App\Models\API;
use App\Models\Client;
use App\Models\Roles;
use App\Models\Duty;
use App\Models\Notification;
use App\Models\Privilege;
use App\Models\Permission;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ExchangeRate;
use App\Models\License;
use App\Models\Software;
use Carbon\Carbon;

use Flutterwave\Controller\PaymentController;
use Flutterwave\EventHandlers\ModalEventHandler as PaymentHandler;
use Flutterwave\Flutterwave;
use Flutterwave\Library\Modal;

// Helper function to check for vulnerable passwords
if (!function_exists('system_vulnerable_password')) {
    function system_vulnerable_password()
    {
        return [
            '12345678',
            'password',
            'qwerty',
            '111111',
            'abc123',
            'password1',
            '123123',
            'letmein',
            'welcome',
            '1234',
            'admin123',
            'sunshine',
            'princess',
            'football',
        ];
    }
}

// Helper function to check if the email domain is supported
if (!function_exists('system_support_emails')) {
    function system_support_emails($email)
    {
        $supported = ['@gmail.com', '@outlook.com'];
        $not_supported = ['@yahoo.com', '@mozmail.com'];

        foreach ($supported as $domain) {
            if (str_contains($email, $domain)) {
                return true; // Supported email domain
            }
        }

        foreach ($not_supported as $domain) {
            if (str_contains($email, $domain)) {
                return false; // Unsupported email domain
            }
        }

        return false; // If email doesn't match any domains, consider it unsupported
    }
}

// Helper function to logout and terminate session
if (!function_exists('system_logout')) {
    function system_logout()
    {
        Auth::guard('web')->logout();  // Use the 'web' guard to log out
        return redirect()->route('login');  // Redirect to the login page
    }
}

if (!function_exists('system_support')) {
    function system_support($feature)
    {
        return true;
    }
}
if (!function_exists('hash_fields')) {
    function hash_fields()
    {
        return ['user_id', 'amount', 'currency', 'created_at', 'sending_addresss', 'recieving_addresss'];
    }
}
if (!function_exists('generate_transaction_hash')) {

    /**
     * Generates a hash for a transaction based on selected fields.
     * 
     * @param array $transactionData The transaction data to hash.
     * 
     * @return string The generated hash.
     */
    function generate_transaction_hash(array $transactionData)
    {
        // Filter data to include only selected fields
        $filteredData = array_intersect_key($transactionData, array_flip(hash_fields()));

        // Sort data to ensure consistent hash generation
        ksort($filteredData);

        // Concatenate data into a string
        $stringData = json_encode($filteredData);

        // Generate hash using HMAC with SHA-256
        $secretKey = env('HASH_SECRET_KEY', 'default_key'); // Define a secret key in .env
        return hash_hmac('sha256', $stringData, $secretKey);
    }
}

if (!function_exists('validate_transaction_hash')) {

    /**
     * Validates the hash of a transaction.
     * 
     * @param string $storedHash The hash stored in the database.
     * @param array $transactionData The transaction data to validate.
     * 
     * @return bool True if the hash is valid, false otherwise.
     */
    function validate_transaction_hash(string $storedHash, array $transactionData,)
    {
        // Generate a new hash from the provided data and fields
        $generatedHash = generate_transaction_hash($transactionData, hash_fields());

        // Compare the stored hash with the generated hash
        return hash_equals($storedHash, $generatedHash);
    }
}


if (!function_exists('system_exchange_rate')) {

    function system_exchange_rate($base_currency, $target_currency, $amount)
    {
        if (!is_string($base_currency) || !is_string($target_currency) || !is_numeric($amount)) {
            Log::error('Invalid parameters provided to system_exchange_rate', [
                'base_currency' => $base_currency,
                'target_currency' => $target_currency,
                'amount' => $amount,
            ]);
            return null;
        }
        if ($base_currency == $target_currency) {

            // Perform calculations
            $rate = 1;
            $tokens = $amount * $rate;
            $vas = $tokens * 0.0211; // Calculate the base fee
            $vat = $tokens * 0.0321;   // Calculate the VAT (7.5%)
            $fee = $vas + $vat; // Total fee including VAT

            // Apply discounts based on the token range
            if ($tokens > 5000 && $tokens <= 10000) {
                $discountedFee = $fee - ($fee * 0.1);
                $fee = ($discountedFee > 200) ? 200 : $discountedFee;
            } elseif ($tokens > 10000 && $tokens <= 50000) {
                $discountedFee = $fee - ($fee * 0.1);
                $fee = ($discountedFee > 250) ? 250 : $discountedFee;
            } elseif ($tokens > 50000 && $tokens <= 70000) {
                $discountedFee = $fee - ($fee * 0.2);
                $fee = ($discountedFee > 300) ? 300 : $discountedFee;
            } elseif ($tokens > 70000 && $tokens <= 100000) {
                $discountedFee = $fee - ($fee * 0.3);
                $fee = ($discountedFee > 450) ? 450 : $discountedFee;
            } elseif ($tokens > 100000 && $tokens <= 200000) {
                $discountedFee = $fee - ($fee * 0.4);
                $fee = ($discountedFee > 600) ? 600 : $discountedFee;
            } elseif ($tokens > 200000 && $tokens <= 500000) {
                $discountedFee = $fee - ($fee / 0.5);
                $fee = ($discountedFee > 800) ? 800 : $discountedFee;
            } elseif ($tokens > 500000 && $tokens <= 1000000) {
                $discountedFee = $fee - ($fee / 0.5);
                $fee = ($discountedFee > 1000) ? 1000 : $discountedFee;
            } elseif ($tokens > 1000000) {
                $discountedFee = $fee - ($fee / 0.5);
                $fee = ($discountedFee > 2000) ? 2000 : $discountedFee;
            }
            $total = $tokens - $fee;

            return [
                'rate' => $rate,
                'from' => $base_currency,
                'to' => $target_currency,
                'amount' => $amount,
                'tokens' => $tokens,
                'fee' => $fee,
                'total' => $total,
            ];
        }
        try {
            // Check if the exchange rate exists and is recent (less than 1 hour old)
            $existingRate = ExchangeRate::where('base_currency', $base_currency)
                ->where('target_currency', $target_currency)
                ->where('updated_at', '>=', Carbon::now()->subHour())
                ->first();

            if ($existingRate) {
                $rate = $existingRate->rate; // Use cached rate
            } else {
                // Fetch new rate from the API
                $api_key = env('EXCHANGE_RATE_API_KEY', null);

                if (empty($api_key)) {
                    Log::error('Exchange Rate API key is not set in .env');
                    return null;
                }

                $response = Http::get("https://v6.exchangerate-api.com/v6/{$api_key}/pair/{$base_currency}/{$target_currency}");

                if ($response->successful()) {
                    $data = $response->json();
                    $rate = $data['conversion_rate'] ?? 0;

                    if ($rate > 0) {
                        // Store the new rate in the database
                        ExchangeRate::updateOrCreate(
                            ['base_currency' => $base_currency, 'target_currency' => $target_currency],
                            ['rate' => $rate]
                        );
                    } else {
                        Log::warning('Invalid exchange rate fetched', [
                            'base_currency' => $base_currency,
                            'target_currency' => $target_currency,
                            'rate' => $rate,
                        ]);
                        return null;
                    }
                } else {
                    Log::error('Failed to fetch exchange rate from API', [
                        'base_currency' => $base_currency,
                        'target_currency' => $target_currency,
                        'response_status' => $response->status(),
                    ]);
                    return null;
                }
            }

            // Perform calculations
            $tokens = $amount * $rate;

            $vas = $tokens * 0.0211; // Calculate the base fee
            $vat = $tokens * 0.0321;   // Calculate the VAT (7.5%)
            $fee = $vas + $vat; // Total fee including VAT

            // Apply discounts based on the token range
            if ($tokens > 5000 && $tokens <= 10000) {
                $discountedFee = $fee - ($fee * 0.1);
                $fee = ($discountedFee > 200) ? 200 : $discountedFee;
            } elseif ($tokens > 10000 && $tokens <= 50000) {
                $discountedFee = $fee - ($fee * 0.1);
                $fee = ($discountedFee > 250) ? 250 : $discountedFee;
            } elseif ($tokens > 50000 && $tokens <= 70000) {
                $discountedFee = $fee - ($fee * 0.2);
                $fee = ($discountedFee > 300) ? 300 : $discountedFee;
            } elseif ($tokens > 70000 && $tokens <= 100000) {
                $discountedFee = $fee - ($fee * 0.3);
                $fee = ($discountedFee > 450) ? 450 : $discountedFee;
            } elseif ($tokens > 100000 && $tokens <= 200000) {
                $discountedFee = $fee - ($fee * 0.4);
                $fee = ($discountedFee > 600) ? 600 : $discountedFee;
            } elseif ($tokens > 200000 && $tokens <= 500000) {
                $discountedFee = $fee - ($fee / 0.5);
                $fee = ($discountedFee > 800) ? 800 : $discountedFee;
            } elseif ($tokens > 500000 && $tokens <= 1000000) {
                $discountedFee = $fee - ($fee / 0.5);
                $fee = ($discountedFee > 1000) ? 1000 : $discountedFee;
            } elseif ($tokens > 1000000) {
                $discountedFee = $fee - ($fee / 0.5);
                $fee = ($discountedFee > 2000) ? 2000 : $discountedFee;
            }
            $total = $tokens - $fee;

            return [
                'rate' => $rate,
                'from' => $base_currency,
                'to' => $target_currency,
                'amount' => $amount,
                'tokens' => $tokens,
                'fee' => $fee,
                'total' => $total,
            ];
        } catch (\Exception $e) {
            Log::error('Fatal error in system_exchange_rate', [
                'base_currency' => $base_currency,
                'target_currency' => $target_currency,
                'amount' => $amount,
                'error_message' => $e->getMessage(),
            ]);
            return null;
        }
    }
}

if (!function_exists('system_product_state')) {
    /**
     * Get predefined product states with details.
     *
     * @return array
     */
    function system_product_state(): array
    {
        return [
            [
                'name' => 'Solid',
                'state' => 'solid',
                'description' => 'A state where matter maintains a fixed volume and shape.',
                'examples' => 'ball, box, phone',
            ],
            [
                'name' => 'Liquid',
                'state' => 'liquid',
                'description' => 'A state where matter takes the shape of its container and flows freely.',
                'examples' => 'water, oil, juice',
            ],
            [
                'name' => 'Gas',
                'state' => 'gas',
                'description' => 'A state where matter expands freely and fills any container it is placed in.',
                'examples' => 'air, helium, steam',
            ],
        ];
    }
}

if (!function_exists('system_standard_weight')) {
    /**
     * Convert a weight value to kilograms (kg).
     *
     * @param string $unit The unit of the weight (e.g., 'kg', 'g', 'lb', 'ton').
     * @param float $value The weight value to convert.
     * @return float The weight value in kilograms.
     * @throws InvalidArgumentException if the unit is unsupported.
     */
    function system_standard_weight(string $unit, float $value): float
    {
        $conversion_factors = [
            'kg' => 1,           // Kilogram
            'g' => 0.001,        // Gram
            'mg' => 0.000001,    // Milligram
            'lb' => 0.453592,    // Pound
            'oz' => 0.0283495,   // Ounce
            'ton' => 1000,       // Metric Ton
        ];

        $unit = strtolower(trim($unit));

        if (!isset($conversion_factors[$unit])) {
            throw new InvalidArgumentException("Unsupported weight unit: $unit");
        }

        return $value * $conversion_factors[$unit];
    }
}

if (!function_exists('calculate_shipping_fee')) {
    /**
     * Calculate the shipping fee in Naira.
     *
     * @param float $distance_in_meters The shipping distance in meters.
     * @param float $weight The weight of the product in kilograms.
     * @param bool $is_fragile Whether the product is fragile.
     * @return float The calculated shipping fee in Naira.
     */
    function calculate_shipping_fee(float $distance_in_meters, float $weight, bool $is_fragile): float
    {
        $base_rate_per_kg = 500; // Naira per kg
        $distance_rate = 0.05;  // Naira per meter
        $fragile_surcharge = 200; // Flat fee for fragile items

        $weight_fee = $weight * $base_rate_per_kg;
        $distance_fee = $distance_in_meters * $distance_rate;
        $fragile_fee = $is_fragile ? $fragile_surcharge : 0;

        return $weight_fee + $distance_fee + $fragile_fee;
    }
}

if (!function_exists('system_si_unit')) {
    /**
     * Get supported SI units for weight with their conversion factors to kilograms.
     *
     * @return array
     */
    function system_si_unit(): array
    {
        return [
            ['title' => 'kilogram', 'symbol' => 'kg', 'conversion_factor' => 1],
            ['title' => 'gram', 'symbol' => 'g', 'conversion_factor' => 0.001],
            ['title' => 'milligram', 'symbol' => 'mg', 'conversion_factor' => 0.000001],
            ['title' => 'pound', 'symbol' => 'lb', 'conversion_factor' => 0.453592],
            ['title' => 'ounce', 'symbol' => 'oz', 'conversion_factor' => 0.0283495],
            ['title' => 'metric ton', 'symbol' => 'ton', 'conversion_factor' => 1000],
        ];
    }
}

// if (!function_exists('client_notification')) {
//     function client_notification($client_id, $title, $content, $level)
//     {
//         $users = User::where('client_id', $client_id)->get(); // Get users by client ID
//         $notice = [];
//         foreach ($users as $user) {
//             $notice = [
//                 'user_id' => $user->id,
//                 'type' => 'client',
//                 'title' => $title,
//                 'content' => $content,
//                 'level' => $level,
//                 'client_id' => $client_id,
//                 'status' => 'unread',
//             ];
//         }

//         Notification::insert($notice);
//     }
// }

// if (!function_exists('general_notification')) {
//     function general_notification($title, $content, $level)
//     {
//         $users = User::get(); // Retrieve all users
//         $notice = [];
//         foreach ($users as $user) {
//             $notice = [
//                 'user_id' => $user->id,
//                 'type' => 'client',
//                 'title' => $title,
//                 'content' => $content,
//                 'level' => $level,
//                 'status' => 'unread',
//             ];
//         }

//         Notification::insert($notice);
//     }
// }

// if (!function_exists('system_notification')) {
//     function system_notification($user, $title, $content, $level)
//     {
//         Notification::create([
//             'user_id' => $user->id ?? $user, // Pass the User ID
//             'type' => 'system',     // Notification type
//             'title' => $title,      // Notification title
//             'content' => $content,  // Notification content
//             'level' => $level,
//             'status' => 'unread',   // Default status
//         ]);
//     }
// }

// if (!function_exists('system_generate_new_api_key')) {
//     function system_generate_new_api_key(): string
//     {
//         // Generate 8 random bytes and convert to uppercase hexadecimal (16 characters)
//         // You can format it with dashes if desired.
//         return strtoupper(bin2hex(random_bytes(16)));
//     }
// }

// if (!function_exists('system_new_licence')) {
//     function system_new_licence($client_id, $user_id, $software_id,  $license_type, $ownership, $amount_payed, $payment_type)
//     {
//         DB::beginTransaction();
//         try {
//             $user = User::find(read($user_id));
//             $client = Client::find(read($client_id));
//             $software = Software::find(read($software_id));
//             if (!$user) {
//                 return response()->json([
//                     'status' => 'error',
//                     'message' => 'User or Client not found please contact support!',
//                     'data' => []
//                 ]);
//             }
//             if (!$software) {
//                 return response()->json([
//                     'status' => 'error',
//                     'message' => 'Software not found please contact support!',
//                     'data' => []
//                 ]);
//             }

//             $license = new License();

//             $license->user_id = $user->id;
//             $license->client_id = $client->id;
//             $license->ownership = $ownership == 'multiple' ? 'multiple' : 'single';
//             $license->software_id = $software->id;
//             $license->key = system_generate_new_api_key();
//             $license->license_type = $license_type;
//             $license->status = 'active';
//             $license->is_active = true;
//             $license->activated_at = now();
//             $license->expires_at = now()->addYear();
//             $license->activated_devices = json_encode([]);
//             $hash = write($license->key . $license->ownership . $software->id . $user->name . $user->id);
//             $certificate = <<<EOT
//             -----BEGIN CERTIFICATE-----
//             Type:: $license->license_type
//             Active:: $license->activated_at
//             Expire:: $license->expires_at
//             Price:: $amount_payed
//             Payment:: $payment_type
//             Owner:: $user->name
//             Software:: $software->name
//             Software Key:: $software->api_key
//             License Key:: $license->key
//             ----------------------------
//             Hash:: $hash
//             -----END CERTIFICATE-----
//             EOT;
//             $license->certificate = $certificate;
//             $license->save();
//             DB::commit();

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'License activated successfully!',
//                 'data' => [
//                     'certificate' => $certificate,
//                     'key' => $license->key,
//                     'user' => $user->id,
//                     'software' => $software->name,
//                     'software_key' => $software->api_key,
//                     'status' => $license->status,
//                 ]
//             ]);
//         } catch (\Exception $e) {
//             DB::rollBack();
//             Log::error('License activation failed: ' . $e->getMessage());
//             return response()->json([
//                 'status' => 'error',
//                 'message' => ':( An error: License not activated please contact support!',
//                 'data' => $e->getMessage()
//             ]);
//         }
//     }
// }
// if (!function_exists('system_license_check')) {

//     function system_license_check()
//     {
//         try {
//             // Ensure user is authenticated
//             if (!Auth::check()) {
//                 return false;
//             }

//             // Get the admin user ID of the school
//             $adminId = Auth::user()->client->id ?? null;

//             if (!$adminId) {
//                 Log::warning("License check failed: Admin ID not found.");
//                 return false;
//             }

//             // Retrieve the license for the admin user
//             $license = License::where('user_id', $adminId)->first();

//             // Check if license exists
//             if (!$license) {
//                 Log::warning("License check failed: No license found for Admin ID: $adminId");
//                 return false;
//             }

//             // Check if license is active
//             if (!$license->is_active) {
//                 Log::warning("License check failed: License is inactive for Admin ID: $adminId");
//                 return false;
//             }

//             // Check if license is expired
//             if (now()->greaterThan($license->expires_at)) {
//                 Log::warning("License check failed: License expired for Admin ID: $adminId");
//                 return false;
//             }

//             // License is valid
//             return true;
//         } catch (\Exception $e) {
//             Log::error("License check error: " . $e->getMessage());
//             return false;
//         }
//     }
// }

// if (!function_exists('system_verify_api_key')) {
//     function system_verify_api_key($publicKey, $secretKey = null)
//     {
//         // Search for the API key in the database
//         $api = API::where('public_key', $publicKey)->first();

//         // If API key does not exist
//         if (!$api) {
//             return [
//                 'status' => 'error',
//                 'message' => 'Invalid API Key',
//                 'data' => [],
//             ];
//         }

//         // Check if the secret key matches
//         if (!($api->secret_key == read($secretKey))) {
//             return [
//                 'status' => 'error',
//                 'message' => 'Invalid Secret Key',
//                 'data' => [],
//             ];
//         }

//         // Check if the API key is active
//         if ($api->status !== 'active') {
//             return [
//                 'status' => 'error',
//                 'message' => 'API Key is inactive',
//                 'data' => [],
//             ];
//         }

//         // Check if the API key is expired
//         if ($api->expires_at && now()->greaterThan($api->expires_at)) {
//             return [
//                 'status' => 'error',
//                 'message' => 'API Key has expired',
//                 'data' => [],
//             ];
//         }

//         // API key is valid
//         return [
//             'status' => 'success',
//             'message' => 'API Key verified',
//             'data' => [
//                 'user_id' => $api->user_id,
//                 'client_id' => $api->client_id,
//                 'permissions' => $api->permissions,
//             ],
//         ];
//     }
// }
