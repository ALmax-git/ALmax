<?php

namespace App\Http\Controllers;

use App\Models\API;
use App\Models\License;
use App\Models\Software;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class ThirdPartyController extends Controller
{
    protected $data = [
        'status' => 'success',  // You can change this dynamically
        'message' => 'API data received',
        'data' => [],
    ];
    public function test()
    {
        $license = system_new_licence(write(1), write(1), write(1), 'trial', 'single', 0, 'external');
        return response()->json([
            'status' => 'success',
            'message' => "Software LICENSE created successfully",
            'data' => $license,
        ]);
    }
    public function index(Request $request)
    {

        // Retrieve API keys from headers
        $publicKey = $request->header('X-Public-Key');
        $secretKey = $request->header('X-Secret-Key');

        // Verify API key using the helper function
        $verification = system_verify_api_key($publicKey, $secretKey);

        if ($verification['status'] !== 'success') {
            return response()->json($verification, 403); // Return error response if invalid
        }


        if ($publicKey) {
            $api = API::where('public_key', $publicKey)->first();
            $user = User::find($api->user_id);
            $this->data['data'] = [
                'username' => $user->name,
                'first_name' => $user->first_name,
                'surname' => $user->surname,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'client' => $user->client->name,
                'profile_picture' => url(asset('storage/' . $user->profile_photo_path)),
            ];
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API Key',
            ], 400);
        }

        return response()->json($this->data);
    }

    public function products(Request $request)
    {
        // 1. API Key Validation
        $publicKey = $request->header('X-Public-Key');
        $secretKey = $request->header('X-Secret-Key');
        $verification = system_verify_api_key($publicKey, $secretKey);

        if ($verification['status'] !== 'success') {
            return response()->json($verification, 403);
        }

        // 2. Fetch User & Products with Eager Loading
        $api = API::with('user.products.images')->where('public_key', $publicKey)->first();

        if (!$api || !$api->user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API user or keys',
            ], 403);
        }

        // 3. Filter products & pick only useful fields
        $products = $api->user->products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'sub_title' => $product->sub_title,
                'key' => $product->key,
                'category' => $product->category_name(),
                'price' => [
                    'stock' => $product->stock_price,
                    'sale' => $product->sale_price,
                ],
                'stock' => [
                    'available' => $product->available_stock,
                    'unit' => $product->si_unit,
                    'weight' => $product->weight,
                ],
                'status' => $product->status,
                'images' => $product->images->map(function ($image) {
                    return [
                        'file' => asset('storage/' . $image->file_path),
                        'alt' => $image->description,
                    ];
                }),
            ];
        });

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No products found for this user',
            ], 404);
        }

        // 4. Response
        return response()->json([
            'status' => 'success',
            'message' => 'Products retrieved successfully',
            'data' => $products,
        ]);
    }

    public function user_wallet(Request $request)
    {

        // Retrieve API keys from headers
        $publicKey = $request->header('X-Public-Key');
        $secretKey = $request->header('X-Secret-Key');

        // Verify API key using the helper function
        $verification = system_verify_api_key($publicKey, $secretKey);

        if ($verification['status'] !== 'success') {
            return response()->json($verification, 403); // Return error response if invalid
        }


        if ($publicKey) {
            $api = API::where('public_key', $publicKey)->first();
            $user = User::find($api->user_id);

            $this->data['data'] = [
                'username' => $user->name,
                'wallet_address' => $user->wallet->wallet_address,
                'balance' => $user->wallet->balance,
                'email' => $user->email,
                'client' => $user->client->name,
            ];
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid API Key',
            ], 400);
        }

        return response()->json($this->data);
    }
    public function new_license(Request $request)
    {
        if (!$request->has('email')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email is Required',
            ], 400);
        } elseif (!$request->input('software_id')) {
            return response()->json([
                'status' => 'error',
                'message' => 'software_id is Required',
                // 'data' => $request
            ], 400);
        }
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $user_id = $user->id;
            $client_id = $user->client->id;
        } else {
            $user = new User();
            $user->name = $request->input('email');
            $user->email = $request->input('email');
            $user->password = Hash::make('passw@rd11223344');
            $user->client_id = 1;
            $user->save();
            $client_id = $user->client->id;
        }
        $software = Software::where('api_key', $request->input('software_id'))->first();
        if (!$software) {
            return response()->json([
                'status' => 'error',
                'message' => 'software Not found on our record! please try again',
            ], 400);
        }
        $software_id = $software->id;

        $license = system_new_licence(write($client_id), write($user_id), write($software_id),  $request->input('license_type'), 'single', $request->input('price'), 'external');
        return response()->json([
            'status' => 'success',
            'message' => "Software LICENSE created successfully",
            'data' => $license,
        ]);
    }
    public function software(Request $request, $type)
    {
        // Retrieve API keys from headers
        $publicKey = $request->header('X-Public-Key');
        $secretKey = $request->header('X-Secret-Key');

        // Verify API key using the helper function
        $verification = system_verify_api_key($publicKey, $secretKey);

        if ($verification['status'] !== 'success') {
            return response()->json($verification, 403); // Return error response if invalid
        }

        // Validate the type parameter (allowed values: all, latest)
        if (!in_array($type, ['all', 'latest'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid type. Allowed values: all, latest',
            ], 400);
        }

        // Example: Fetch software based on type
        $softwareQuery = \App\Models\Software::query();

        if ($type === 'latest') {
            $softwareQuery->orderBy('created_at', 'desc')->limit(10);
        }

        $software = $softwareQuery->get();

        return response()->json([
            'status' => 'success',
            'message' => "Software list retrieved successfully",
            'data' => $software,
        ]);
    }
}
