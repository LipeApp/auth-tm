<?php

namespace Seshpulatov\AuthTm;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Seshpulatov\AuthTm\Http\Middleware\AuthControlMiddleware;

class TmAuthProvider extends ServiceProvider
{


    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/auth-tm.php' => config_path('auth-tm.php')
        ]);
        $this->loadRoutesFrom(__DIR__ . '/../routes/auth-tm.php');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('auth_tm', AuthControlMiddleware::class);
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'auth-tm');
    }


    public function register()
    {
        $this->app->singleton(AuthTM::class, function () {
            return new AuthTM();
        });
    }

}
