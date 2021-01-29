<?php

namespace UseDB;

use UseDB\Middleware\UseDB;
use Illuminate\Support\ServiceProvider;

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
    }
}
