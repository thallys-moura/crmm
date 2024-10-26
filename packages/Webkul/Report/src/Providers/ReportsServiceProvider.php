<?php

namespace Webkul\Reports\Providers;

use Illuminate\Support\ServiceProvider;

class ReportsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Carregar o arquivo de rotas específico de relatórios
        $this->loadRoutesFrom(__DIR__ . '/../routes/report_routes.php');
    }

    public function register()
    {
        // Registrar outros serviços e dependências se necessário
    }
}