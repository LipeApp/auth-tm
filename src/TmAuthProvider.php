<?php

namespace Seshpulatov\AuthTm;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Seshpulatov\AuthTm\Helper\Coder;
use Seshpulatov\AuthTm\Http\Middleware\ApiUserLogin;
use Seshpulatov\AuthTm\Http\Middleware\ApiUserOptionalLogin;
use Seshpulatov\AuthTm\Http\Middleware\AuthControlMiddleware;

class TmAuthProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/auth-tm.php' => config_path('auth-tm.php'),
            __DIR__ . '/../resources/views'    => resource_path('views/vendor/auth-tm'),
        ]);

        $this->loadRoutesFrom(__DIR__ . '/../routes/auth-tm.php');

        $this->app->alias('AuthTM', AuthTM::class);

        $router = $this->app->make(Router::class);

        $router->aliasMiddleware('auth_tm', AuthControlMiddleware::class);
        $router->aliasMiddleware('api_login_tm', ApiUserLogin::class);
        $router->aliasMiddleware('api_optional_login_tm', ApiUserOptionalLogin::class);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'auth-tm');
    }

    public function register()
    {
        $this->app->bind(Coder::class, function () {
            return new Coder();
        });

        $this->app->singleton(AuthTM::class, function () {
            return new AuthTM();
        });
    }

}
