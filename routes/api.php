<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DynamicPageController;
use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\SystemSettingController;
use Illuminate\Http\Request;
use App\Http\Controllers\API\UserAuthController;
use Illuminate\Support\Facades\Route;



Route::controller(UserAuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('/logout', 'logout');
    Route::post('/password/send-otp', 'sendOtp');
    Route::post('/password/verify-otp', 'verifyOtp');
    Route::post('/password/reset', 'resetPassword');
});

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('me', [UserAuthController::class, 'me']);
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/subCategories', [SubCategoryController::class, 'index']);

Route::get('/product', [ProductController::class, 'index']);

Route::get('/faq', [FAQController::class, 'index']);

Route::get('/dynamicPage', [DynamicPageController::class, 'index']);

Route::get('/system', [SystemSettingController::class, 'index']);
