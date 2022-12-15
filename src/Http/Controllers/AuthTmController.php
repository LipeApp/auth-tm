<?php

namespace Seshpulatov\AuthTm\Http\Controllers;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * @return Application|Factory|View
     */
    public function defaultPage()
    {
        return view('auth-tm::default-page');
    }

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

        $userData = (array)$json->user;

        AuthTM::setUser($userData);

        $route = data_get($json, 'route');

        if (empty($route) || Route::has($route)) {
            $url = config('auth-tm.after_login_url');
        } else {
            $url = route($route);
        }

        $cookie = \Cookie::make(AuthTM::getCookieKey(), $json->token, 24 * 60 * 7);
        \Cookie::queue($cookie);
        return redirect($url);
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function logout()
    {
        AuthTM::logout();
        return redirect(config('auth-tm.after_logout_url'));
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
