<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('app');
})->name('app');
Route::get('/systemd', [RequestController::class, 'trackRequest']);

Route::get('/user/profile', function () {
    return redirect()->route('app');
})->name('profile.show');

Route::get('/{any}', function () {
    return redirect()->route('app');
});
