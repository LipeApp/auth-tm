<?php

namespace Seshpulatov\AuthTm;

use Illuminate\Support\ServiceProvider;

class TmAuthProvider extends ServiceProvider
{


    public function boot(){
        $this->publishes([
            __DIR__.'/../config/auth_tm.php' => config_path('auth_tm.php')
        ]);
        $this->loadRoutesFrom(__DIR__.'/../routes/auth_tm.php');
    }



    public function register()
    {
        $this->app->singleton(AuthTM::class, function (){
            return new AuthTM();
        });
    }

}
