<?php

namespace App\Providers;

use App\Models\SystemSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }



    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->runningInConsole() === false || \Illuminate\Support\Facades\Schema::hasTable('system_settings')) {
            try {
                View::share('setting', SystemSetting::first());
            } catch (\Exception $e) {
                // Table might not exist yet during migration
            }
        }


         Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

    }




    // public function boot()
    // {
    //     Gate::define('manage-role-permission', function ($user) {
    //         return $user->hasRole('Super Admin');
    //     });
    // }
}
