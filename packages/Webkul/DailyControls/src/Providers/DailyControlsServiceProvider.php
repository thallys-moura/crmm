<?php 

namespace Webkul\DailyControls\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class DailyControlsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @param Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        // Carrega as migrações
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Registre qualquer dependência ou binding necessária
    }
}