<?php

namespace Seshpulatov\AuthTm\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Seshpulatov\AuthTm\AuthTM;
use Seshpulatov\AuthTm\Helper\Coder;

class AuthTmController extends BaseController
{
    public function login(){
        $coder = new Coder();
        $json = json_decode($coder->decrypt(request()->input('data')));
        \Cache::remember($json->token."_user", 60 * 24 * 7, function () use ($json){
            return $json->user;
        });

        return redirect(route($json->route))->withCookie(cookie()->forever(config('auth_tm.auth_session_key'), $json->token));
    }
    public function test(){
        dd('test');
    }

    public function logout(){
        return AuthTM::logout();
    }
    public function routes()
    {
        $routes = [];
        collect(\Route::getRoutes())->map(function ($route) use ($routes){
            if(str_contains($route->getActionName(), "App\Http\Controllers") && !str_contains($route->getActionName(), "App\Http\Controllers\Api")){
                $routes[] = $route->getName();
            }
        });
        $coder = new Coder();
        return response()->json(['data'=>$coder->encrypt(json_encode($routes))]);
    }


}
