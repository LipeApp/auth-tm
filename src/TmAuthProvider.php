<?php

namespace Seshpulatov\AuthTm;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Seshpulatov\AuthTm\Http\Middleware\AuthControl;

class TmAuthProvider extends ServiceProvider
{


    public function boot(){
        $this->publishes([
            __DIR__.'/../config/auth_tm.php' => config_path('auth_tm.php')
        ]);
        $this->loadRoutesFrom(__DIR__.'/../routes/auth_tm.php');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('capitalize', AuthControl::class);
    }



    public function register()
    {
        $this->app->singleton(AuthTM::class, function (){
            return new AuthTM();
        });
    }

}
