<?php

use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\GuardMiddleware;
use Illuminate\Support\Facades\Auth;
use Flutterwave\Flutterwave;

Route::get('/', function () {
    $model = '';
    if (url('/') ==  env('NodePulse_url')) {
        $model = 'NodePulse';
    }
    if (Auth::user()) {
        return view(
            'app',
            [
                'model' => $model,
            ]
        );
    } else {
        switch (url('/')) {
            case env('NodePulse_url'):
                return redirect()->route('login');
            case env('EventPulse_url'):
                return view('app.event.welcome');
                break;
            case env('kycspot_url'):
                return view('app.KYCspot.welcome');
                break;
            default:
                return view('app.ALmax.welcome');
                break;
        }
    }
})->name('app');

Route::get('/events', function () {
    return view('app.event.welcome');
})->name('events');

Route::get('gate', function () {
    return view('gate.index');
})->name('gate');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    GuardMiddleware::class,
])->group(
    function () {

        Route::get('/systemd', [RequestController::class, 'trackRequest'])->name('systemd');

        Route::get('communities/{email}', function ($email) {
            $decodedEmail = urldecode($email);
            return view('app', [
                'email' => $decodedEmail,
            ]);
        })->name('community.profile');

        Route::get('/user/profile', function () {
            return redirect()->route('app');
        })->name('profile.show');

        Route::post('/ticket', [FlutterwaveController::class, 'new_ticket'])->name('new_ticket');
        Route::get('/ticket', [FlutterwaveController::class, 'ticket_callback'])->name('ticket_callback');

        Route::post('/checkout', [FlutterwaveController::class, 'checkout'])->name('checkout');
        Route::get('/checkout', [FlutterwaveController::class, 'checkout_fallback'])->name('checkout_fallback');
    }
);

Route::post('flutterwave/payment/webhook', function () {
    $method = request()->method();
    if ($method === 'POST') {
        //get the request body
        $body = request()->getContent();
        $webhook = Flutterwave::use('webhooks');
        $transaction = Flutterwave::use('transactions');
        //get the request signature
        $signature = request()->header($webhook::SECURE_HEADER);

        //verify the signature
        $isVerified = $webhook->verifySignature($body, $signature);

        if ($isVerified) {
            ['tx_ref' => $tx_ref, 'id' => $id] = $webhook->getHook();
            ['status' => $status, 'data' => $transactionData] = $transaction->verifyTransactionReference($tx_ref);

            $responseData = ['tx_ref' => $tx_ref, 'id' => $id];
            if ($status === 'success') {
                switch ($transactionData['status']) {
                        // case Status::SUCCESSFUL:
                        //     // do something
                        //     //save to database
                        //     //send email
                        //     break;
                        // case Status::PENDING:
                        //     // do something
                        //     //save to database
                        //     //send email
                        //     break;
                        // case Status::FAILED:
                        //     // do something
                        //     //save to database
                        //     //send email
                        //     break;
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Webhook verified by Flutterwave Laravel Package', 'data' => $responseData]);
        }

        return response()->json(['status' => 'error', 'message' => 'Access denied. Hash invalid'])->setStatusCode(401);
    }

    // return 404
    return abort(404);
})->name('flutterwave.webhook');
