<?php

use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\GuardMiddleware;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::user()) {
        return view('app');
    } else {
        switch (url('/')) {
            case 'http://eventpulse.localhost':
                return view('app.event.welcome');
                break;

            default:
                return view('app.ALmax.welcome');
                break;
        }
    }
})->name('app');

Route::get('/systemd', [RequestController::class, 'trackRequest']);

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

        Route::get('communities/{email}', function ($email) {
            $decodedEmail = urldecode($email);
            return view('app', [
                'email' => $decodedEmail,
            ]);
        })->name('community.profile');

        Route::post('/new_ticket', [FlutterwaveController::class, 'new_ticket'])->name('new_ticket');
        Route::get('/new_ticket', [FlutterwaveController::class, 'fallback'])->name('fallback');
    }
);

Route::get('/callback', [FlutterwaveController::class, 'callback'])->name('callback');

Route::get('/user/profile', function () {
    return redirect()->route('app');
})->name('profile.show');


// Route::post('flutterwave/payment/webhook', function () {
//     $method = request()->method();
//     if ($method === 'POST') {
//         //get the request body
//         $body = request()->getContent();
//         $webhook = Flutterwave::use('webhooks');
//         $transaction = Flutterwave::use('transactions');
//         //get the request signature
//         $signature = request()->header($webhook::SECURE_HEADER);

//         //verify the signature
//         $isVerified = $webhook->verifySignature($body, $signature);

//         if ($isVerified) {
//             ['tx_ref' => $tx_ref, 'id' => $id] = $webhook->getHook();
//             ['status' => $status, 'data' => $transactionData] = $transaction->verifyTransactionReference($tx_ref);

//             $responseData = ['tx_ref' => $tx_ref, 'id' => $id];
//             if ($status === 'success') {
//                 switch ($transactionData['status']) {
//                     case Status::SUCCESSFUL:
//                         // do something
//                         //save to database
//                         //send email
//                         break;
//                     case Status::PENDING:
//                         // do something
//                         //save to database
//                         //send email
//                         break;
//                     case Status::FAILED:
//                         // do something
//                         //save to database
//                         //send email
//                         break;
//                 }
//             }

//             return response()->json(['status' => 'success', 'message' => 'Webhook verified by Flutterwave Laravel Package', 'data' => $responseData]);
//         }

//         return response()->json(['status' => 'error', 'message' => 'Access denied. Hash invalid'])->setStatusCode(401);
//     }

//     // return 404
//     return abort(404);
// })->name('flutterwave.webhook');
