<?php

namespace UseDB;

use UseDB\Middleware\UseDB;
use Illuminate\Support\ServiceProvider;
use UseDB\Middleware\Model;

class UseDBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        app('router')->aliasMiddleware('usedb', UseDB::class);
        app('router')->aliasMiddleware('model-usedb', Model::class);

        $this->publishes([
            __DIR__ . '/config/usedb.php' => config_path('usedb.php'),
        ], 'config');
    }
}
