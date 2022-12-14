<?php

namespace Seshpulatov\AuthTm\Http\Controllers;

use Cache;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\JsonResponse;
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
     * @throws BindingResolutionException
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

        if (empty($route) || Route::has($route)) {
            $url = config('auth_tm.default_url');
        } else {
            $url = route($route);
        }
        $cookie = cookie()->make(config('auth_tm.auth_session_key'), $json->token, 24 * 60 * 7);

        return to_route('home')
            ->withCookie($cookie);
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function logout()
    {
        return AuthTM::logout();
    }

    /**
     * @return JsonResponse
     */
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
