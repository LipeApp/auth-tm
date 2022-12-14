<?php

namespace Seshpulatov\AuthTm\Http\Controllers;

use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\Redirector;
use Route;
use Seshpulatov\AuthTm\AuthTM;
use Seshpulatov\AuthTm\Helper\Coder;

class AuthTmController extends BaseController
{
    /**
     * @return Application|RedirectResponse|Redirector|void
     */
    public function login()
    {
        $coder = new Coder();
        if (is_array(request()->input('data'))) {
            exit("AuthTMController");
        }
        $json = json_decode($coder->decrypt(request()->input('data')));
        Cache::remember($json->token . "_user", 60 * 24 * 7, function () use ($json) {
            return $json->user;
        });

        $route = data_get($json, 'route');
        if(empty($route) || Route::has($route)){
            $url = config('auth_tm.default_url');
        }
        else{
            $url = route($route);
        }

        return redirect($url)
            ->withCookie(cookie()->forever(config('auth_tm.auth_session_key'), $json->token));
    }

    public function test()
    {
        dd('test');
    }

    public function logout()
    {
        return AuthTM::logout();
    }

    public function routes()
    {
        collect(Route::getRoutes())->map(function ($route) use (&$routes) {
            if (str_contains($route->getActionName(), "App\Http\Controllers") && !str_contains($route->getActionName(), "App\Http\Controllers\Api")) {
                $routes[] = $route->getName();
            }
        });
        $coder = new Coder();
        return response()->json(['data' => $coder->encrypt(json_encode($routes))]);
    }


}
