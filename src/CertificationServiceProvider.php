<?php

namespace Tomeet\Certification;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class CertificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupRoutes($this->app->router);
        $this->publishes([
            \dirname(__DIR__) . '/config/certification.php' => config_path('certification.php'), // 发布配置文件到 laravel 的config 下
            \dirname(__DIR__) . '/migrations/' => database_path('migrations')
        ], 'tomeet-certification');
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/admin.php');
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/app.php');
    }
}
