<?php

namespace App\Providers;

use App\Services\UtilityService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UtilityService::class, function ($app) {
            return new UtilityService();
        });
    }
}
