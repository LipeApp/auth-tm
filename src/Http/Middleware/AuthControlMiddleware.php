<?php

namespace Seshpulatov\AuthTm\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Seshpulatov\AuthTm\AuthTM;
use Seshpulatov\AuthTm\Helper\Coder;

class AuthControlMiddleware
{
    private Coder $coder;

    public function __construct()
    {
        $this->coder = new Coder();
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (config('app.env') === 'testing') {
            return $next($request);
        }

        $token = AuthTM::getToken();

        if ($token) {

            $check = Http::acceptJson()
                ->withToken($token)
                ->post(config('auth-tm.login_check'), [
                    'route' => Route::currentRouteName(),
                    'service_id' => config('auth-tm.service_id')
                ]);

            if ($check->status() === 401) {
                return AuthTM::login();
            }

            $coder = new Coder();
            $data = $check->json('data');

            $json = json_decode($coder->decrypt($data));

            if (isset($json->success)) {

                $userData = data_get($json, 'user');

                if ($userData) {
                    AuthTM::setUser((array)$userData);
                }

                if ($json->allowed) {
                    return $next($request);
                } else {
                    abort(403);
                }
            }
        }

        AuthTM::logout();
        return AuthTM::login();
    }
}
