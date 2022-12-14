<?php

namespace Seshpulatov\AuthTm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

    public function handle(Request $request, Closure $next)
    {

        if (config('app.env') === 'testing') {
            return $next($request);
        }

        $key = AuthTM::authSessionKey();
        $hasToken = $request->hasCookie($key);

        if ($hasToken) {
            $token = AuthTM::authTmCookieToken();
            $check = Http::acceptJson()
                ->withToken($token)
                ->post(config('auth_tm.login_check'), [
                    'route' => Route::currentRouteName(),
                    'service_id' => config('auth_tm.service_id')
                ]);

            if ($check->status() === 401) {
                return AuthTM::logout();
            }

            $coder = new Coder();
            if (is_array($check->json('data'))) {
                exit("Auth Controller");
            }

            $json = json_decode($coder->decrypt($check->json('data')));

            if (isset($json->success)) {
                if ($json->allowed) {
                    return $next($request);
                } else {
                    abort(403);
                }
            } else {
                return AuthTM::logout();
            }
        }

        AuthTM::logout();
        return AuthTM::login();
    }
}
