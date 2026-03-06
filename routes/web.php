<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesforceAuthController;


// Route::get('/', function () {
//     return view('frontend/welcome');
// });

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/salesforce/login', [SalesforceAuthController::class, 'redirect']);
Route::get('/salesforce/callback', [SalesforceAuthController::class, 'callback']);



require __DIR__.'/auth.php';
require __DIR__.'/frontend.php';


