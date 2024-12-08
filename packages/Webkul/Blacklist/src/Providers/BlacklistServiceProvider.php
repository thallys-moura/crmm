<?php

namespace Webkul\Blacklist\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BlacklistServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {}
}