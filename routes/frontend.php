<?php

use App\Http\Controllers\Web\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;


Route::get('/product-card', [FrontendController::class, 'productCard'])->name('product.card');
Route::post('/add-to-cart', [FrontendController::class, 'addToCart'])->name('product.add-to-cart');
Route::get('/view-cart', [FrontendController::class, 'viewCart'])->name('product.view-cart');