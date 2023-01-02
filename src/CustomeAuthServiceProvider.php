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
        // // $this->publishes([
        // //     __DIR__.'/views' => resource_path('views/vendor/auth'),
        // // ]);

        // $this->commands([
        //     Console\InstallCommand::class,
        // ]);

        // // Directories...
        // (new Filesystem)->ensureDirectoryExists(app_path('Actions/Jetstream'));
        // (new Filesystem)->ensureDirectoryExists(app_path('Actions/Fortify'));

        // copy(__DIR__.'/Contracts/CreateNewUser.php', app_path('Actions/Fortify/CreateNewUser.php'));
        // copy(__DIR__.'/database/2022_12_12_131652_add_google_id_column.php', base_path('database/migrations/2022_12_12_131652_add_google_id_column.php'));
        $this->publishes([
            __DIR__.'/views' => resource_path('views'),
            __DIR__.'/assets' => public_path('assets'),
            __DIR__.'/Http/Controllers' => app_path('/Http/Controllers'),
            __DIR__.'/Http/Requests' => app_path('/Http/Requests'),
            __DIR__.'/routes' => base_path('/routes'),
            __DIR__.'/Composer.php' => base_path('/app/Composer.php'),
        ],'customeauth-view');
        $this->commands([
            Console\InstallCommand::class,
        ]);
    }

}