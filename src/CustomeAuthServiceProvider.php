<?php

namespace Custome\Auth;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;

class CustomeAuthServiceProvider extends ServiceProvider
{
       /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(StatefulGuard::class, function () {
            return Auth::guard('web');
        });
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
        $this->loadViewsFrom(__DIR__.'/views', 'auth');
        // $this->publishes([
        //     __DIR__.'/views' => resource_path('views/vendor/auth'),
        // ]);

        // Directories...
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/Jetstream'));
        (new Filesystem)->ensureDirectoryExists(app_path('Actions/Fortify'));

        copy(__DIR__.'/Contracts/CreateNewUser.php', app_path('Actions/Fortify/CreateNewUser.php'));
        copy(__DIR__.'/database/2022_12_12_131652_add_google_id_column.php', base_path('database/migrations/2022_12_12_131652_add_google_id_column.php'));
    }

}