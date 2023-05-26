<?php

namespace Seshpulatov\AuthTm\Http\Controllers;

use Cookie;
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
    public function __construct(protected Coder $coder)
    {
    }

    /**
     * @return Application|Factory|View
     */
    public function defaultPage(): Factory|View|Application
    {
        return view('auth-tm::default-page');
    }

    /**
     * @return Application|RedirectResponse|Redirector|void
     */
    public function login()
    {

        $data = request()->input('data');

        if (empty($data)) {
            exit('No data: AuthTmController');
        }

        $json = json_decode($this->coder->decrypt($data), true);

        if (is_array($json) && isset($json['user']) && isset($json['token'])) {

            $token = $json['token'];
            $keyName = AuthTM::getCookieKey();

            AuthTM::setUser($json['user']);

            $cookie = Cookie::make(
                name: $keyName,
                value: $token,
                minutes: 24 * 60 * 7,
                httpOnly: false
            );

            Cookie::queue($cookie);

            session()->put($keyName, $token);

            return redirect($json['route'] ?? config('auth-tm.after_login_url'));
        }

        exit('No data: AuthTmController');
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function logout(): Redirector|RedirectResponse|Application
    {
        AuthTM::logout();
        return redirect(config('auth-tm.after_logout_url'));
    }

    /**
     * Get list of all routes in App/Http/Controllers
     *
     * @return JsonResponse
     */
    public function routes(): JsonResponse
    {
        collect(Route::getRoutes())->map(function ($route) use (&$routes) {
            if (str_contains($route->getActionName(), "App\Http\Controllers") && !str_contains($route->getActionName(), "App\Http\Controllers\Api")) {
                $routes[] = $route->getName();
            }
        });
        return response()->json(['data' => $this->coder->encrypt(json_encode($routes))]);
    }
}
