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

        $token = AuthTM::getToken();

        if ($token) {

            $check = Http::acceptJson()
                ->withToken($token)
                ->post(config('auth_tm.login_check'), [
                    'route' => Route::currentRouteName(),
                    'service_id' => config('auth_tm.service_id')
                ]);
            if ($check->status() === 401) {
                return AuthTM::login();
            }

            $coder = new Coder();
            $data = $check->json('data');

            if (is_array($data)) {
                exit("Auth Controller");
            }

            $json = json_decode($coder->decrypt($data));

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
