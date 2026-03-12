<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DynamicPageController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\FCHCCMediaController;
use App\Http\Controllers\API\NewsletterController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SubCategoryController;
use App\Http\Controllers\API\SystemSettingController;
use App\Http\Controllers\API\SponsorController;
use App\Http\Controllers\API\PartnerController;
use App\Http\Controllers\API\SalesforceController;
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


Route::get('/events', [EventController::class, 'index']);

Route::get('/sponsors', [SponsorController::class, 'index']);

Route::get('/media', [FCHCCMediaController::class, 'index']);
Route::get('/partners', [PartnerController::class, 'index']);
Route::get('/news', [NewsController::class, 'index']);

// Salesforce Integration Routes
Route::prefix('salesforce')->middleware('api')->group(function () {
    Route::get('/accounts', [SalesforceController::class, 'accounts']);
    Route::post('/query', [SalesforceController::class, 'query']);
    Route::post('/create', [SalesforceController::class, 'create']);
    Route::post('/update', [SalesforceController::class, 'update']);
    Route::get('/find', [SalesforceController::class, 'find']);
    Route::post('/refresh-token', [SalesforceController::class, 'refreshToken']);
});


Route::post('/subscribe', [NewsletterController::class, 'subscribe']);
