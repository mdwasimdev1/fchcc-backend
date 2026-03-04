<?php

use App\Http\Controllers\Web\Backend\Admin\FAQController;
use App\Http\Controllers\Web\Backend\CategoryController;
use App\Http\Controllers\Web\backend\DashboardController;
use App\Http\Controllers\Web\Backend\ProductController;
use App\Http\Controllers\Web\Backend\RoleController;
use App\Http\Controllers\Web\Backend\EventController;
use App\Http\Controllers\Web\Backend\RolePermissionController;
use App\Http\Controllers\Web\Backend\SalesforceController;
use App\Http\Controllers\Web\Backend\Settings\DynamicPagesController;
use App\Http\Controllers\Web\Backend\Settings\ProfileSettingController;
use App\Http\Controllers\Web\Backend\Settings\SystemSettingController;
use App\Http\Controllers\Web\Backend\StripeController;
use App\Http\Controllers\Web\Backend\SubCategoryController;
use App\Http\Controllers\Web\Backend\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\MediaCollections\Models\Media;





Route::post('/theme-toggle', function () {
     session([
          'theme' => session('theme') === 'dark' ? 'light' : 'dark'
     ]);

     return response()->noContent();
})->name('theme.toggle');


Route::get('/lang/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'es'])) {
        abort(400);
    }

    session(['locale' => $locale]);

    return redirect()->back();
});


// Dashboard
Route::controller(DashboardController::class)->middleware('auth')->group(function () {
     Route::get('/dashboard', 'index')->name('dashboard');

     // Route::get('/user-chart', 'userChart')->name('user.chart');
});

Route::get('/user-chart', [DashboardController::class, 'userChart']);
Route::get('/user-totalUserGrowth', [DashboardController::class, 'totalUserGrowth']);
Route::get('/user-growth', [DashboardController::class, 'userGrowth']);
Route::get('/user-status-growth', [DashboardController::class, 'userStatusGrowth']);






// Category Routes
Route::controller(CategoryController::class)->group(function () {
     Route::get('/category', 'index')->name('category.index');
     Route::post('/category/store', 'store')->name('category.store');
     Route::get('/categories/data', 'getCategories')->name('categories.data');
     Route::get('/category/{id}/edit', 'edit')->name('category.edit');
     Route::post('/category/{id}/update', 'update')->name('category.update');
     Route::delete('/category-delete', 'destroy')->name('category.destroy');
     Route::post('/category/status', 'toggleStatus')->name('category.status');
});

//Sub Category Routes
Route::controller(SubCategoryController::class)->group(function () {
     Route::get('/sub-category', 'index')->name('SubCategory.index');
     Route::post('/sub-category/store', 'store')->name('SubCategory.store');
     Route::get('/sub-category/data', 'getSubCategories')->name('subCategory.data');
     Route::get('/sub-category/{id}/edit', 'edit')->name('subCategory.edit');
     Route::post('/sub-category/update/{id}', 'update')->name('subCategory.update');
     Route::delete('/sub-category/delete', 'destroy')->name('subCategory.destroy');
     Route::post('/sub-category/status', 'toggleStatus')->name('subCategory.status');
});

// Product Routes
Route::controller(ProductController::class)->group(function () {
     Route::get('/product', 'index')->name('product.index');
     Route::get('/product/create', 'create')->name('product.create');
     Route::get('/product/get-subcategories/{category_id}', 'getSubCategories')->name('product.get.subcategories');

     Route::post('/product/store', 'store')->name('product.store');
     Route::get('/product/data', 'getProduct')->name('product.data');
     Route::get('/product/{id}/edit', 'edit')->name('product.edit');
     Route::put('/product/{id}', 'update')->name('product.update');
     Route::delete('/product/delete', 'destroy')->name('product.destroy');
     Route::post('/product/status', 'toggleStatus')->name('product.status');
});


// Event Routes
Route::controller(EventController::class)->group(function () {
     Route::get('/event', 'index')->name('event.index');
     Route::get('/event/create', 'create')->name('event.create');
     Route::post('/event/store', 'store')->name('event.store');
     Route::get('/event/data', 'getEvent')->name('event.data');
     Route::get('/event/{id}/edit', 'edit')->name('event.edit');
     Route::post('/event/update/{id}', 'update')->name('event.update');
     Route::delete('/event/delete', 'destroy')->name('event.destroy');
     Route::post('/event/status', 'toggleStatus')->name('event.status');
});




// Profile Settings Routes
Route::controller(ProfileSettingController::class)->group(function () {
     Route::get('/profile', 'index')->name('profile');
     Route::post('/profile/update', 'updateProfile')->name('profile.update');
     Route::post('/profile/update/password', 'updatePassword')->name('profile.update.password');
     Route::post('/profile/update/profile-picture', 'updateProfilePicture')->name('profile.update.profile.picture');
     Route::get('/checkusernam', 'checkusername')->name('checkusername');
});


// FAQ Routes
Route::controller(FAQController::class)->group(function () {
     Route::get('/faq', 'index')->name('faq.index');
     Route::get('/faq/get', 'get')->name('faq.get');
     Route::post('/faq/priorities', 'priority')->name('faq.priority');
     Route::post('/faq/status', 'status')->name('faq.status');
     Route::post('/faq/store', 'store')->name('faq.store');
     Route::post('/faq/update', 'update')->name('faq.update');
     Route::delete('/faq/destroy', 'destroy')->name('faq.destroy');
});


// Dynamic Pages Route
Route::controller(DynamicPagesController::class)->group(function () {
     Route::get('/dynamicpages', 'index')->name('dynamicpages.index');
     Route::get('/dynamicpages/create', 'create')->name('dynamicpages.create');
     Route::post('/dynamicpages/store', 'store')->name('dynamicpages.store');
     Route::get('/dynamicpages/data', 'getdata')->name('dynamicpages.data');
     Route::get('/dynamicpages/edit/{id}', 'edit')->name('dynamicpages.edit');
     Route::post('/dynamicpages/update/{id}', 'update')->name('dynamicpages.update');
     Route::delete('/dynamicpages/delete', 'destroy')->name('dynamicpages.destroy');
     Route::post('/dynamicpages/status', 'changeStatus')->name('dynamicpages.status');
});



// User Route
Route::controller(UserController::class)->group(function () {
     Route::get('/users',  'index')->name('users.index');
     Route::get('/user/data', 'getdata')->name('user.data');
     Route::get('/users/create', 'create')->name('user.create');
     Route::post('/users/store', 'store')->name('user.store');
     Route::get('/edit/users/{id}', 'edit')->name('user.edit');
     Route::post('/update/user', 'update')->name('user.update');
     Route::get('/view/users/{id}', 'show')->name('show.user');
     Route::post('/status/users', 'changeStatus')->name('user.status');
     Route::delete('/user/delete', 'destroy')->name('user.destroy');


     Route::get('/users/pdf', 'downloadPdf')->name('users.pdf');
});




Route::controller(SystemSettingController::class)->group(function () {
     Route::get('/system/setting', 'systemSetting')->name('system.setting');
     Route::post('/system/setting/update', 'systemSettingUpdate')->name('system.settingupdate');
     Route::get('/setting', 'adminSetting')->name('admin.setting');
     Route::post('/setting/update', 'adminSettingUpdate')->name('admin.settingupdate');
     Route::get('/mail', 'mail')->name('admin.setting.mail');
     Route::post('/mail', 'mailstore')->name('admin.setting.mailstore');




     // Route::get('/general/setting', 'create')->name('general.setting');
     // Route::post('/system/update', 'update')->name('system.update');
     // Route::get('/stripe', 'stripe')->name('admin.setting.stripe');
     // Route::post('/stripe', 'stripestore')->name('admin.setting.stripestore');
     // Route::get('/paypal', 'paypal')->name('admin.setting.paypal');
     // Route::post('/paypal', 'paypalstore')->name('admin.setting.paypalstore');
});





Route::middleware(['auth', 'role:Super Admin'])->group(function () {

     // Role Permission Routes
     Route::get('/role-permissions', [RolePermissionController::class, 'index'])
          ->name('role.permission.index');

     Route::post('/role-permissions/update', [RolePermissionController::class, 'update'])
          ->name('role.permission.update');

     Route::post('/role-permissions/bulk-update', [RolePermissionController::class, 'bulkUpdate'])
          ->name('role.permission.bulk-update');

     // Role CRUD Routes
     Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
     Route::get('/roles/data', [RoleController::class, 'getData'])->name('role.data');
     Route::get('/role/create', [RoleController::class, 'create'])->name('role.create');
     Route::post('/role/store', [RoleController::class, 'store'])->name('role.store');
     Route::get('/role/{id}/edit', [RoleController::class, 'edit'])->name('role.edit');
     Route::post('/role/{id}/update', [RoleController::class, 'update'])->name('role.update');
     Route::delete('/role/delete', [RoleController::class, 'destroy'])->name('role.destroy');
     Route::post('/role/status', [RoleController::class, 'toggleStatus'])->name('role.status');
});



//stripe payment routes
Route::controller(StripeController::class)->group(function () {
     Route::get('/stripe', 'stripe')->name('stripe');
     Route::post('/stripe', 'stripePost')->name('stripe.post');
}); 



// Route::get('stripe', [StripeController::class, 'stripe']);
// Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');



Route::get('/salesforce/connect', [SalesforceController::class, 'connect']);   // OAuth login
Route::get('/salesforce/callback', [SalesforceController::class, 'callback']); // OAuth callback
Route::get('/salesforce/accounts', [SalesforceController::class, 'accounts']); // Fetch Accounts