<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('frontend/welcome');
// });

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');





require __DIR__.'/auth.php';
require __DIR__.'/frontend.php';


