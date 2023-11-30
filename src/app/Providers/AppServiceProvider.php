<?php

namespace App\Providers;

use App\Services\Permissions\Permission;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(Permission::class, function () {
            return new Permission();
        });
    }
}
