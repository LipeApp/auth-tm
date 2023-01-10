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
use Symfony\Component\HttpFoundation\Response;

class AuthControlMiddleware
{
    public function __construct(protected Coder $coder){}

    /**
     * @param Request $request
     * @param Closure $next
     * @return Application|RedirectResponse|Redirector|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {

        if (config('app.env') === 'testing') {
            return $next($request);
        }

        if ( $token = AuthTM::getToken() ) {

            $check = Http::acceptJson()
                ->withToken($token)
                ->post(config('auth-tm.login_check'), [
                    'route' => Route::currentRouteName(),
                    'service_id' => config('auth-tm.service_id')
                ]);

            if ($check->status() === Response::HTTP_UNAUTHORIZED) {
                return AuthTM::login();
            }

            $data = $check->json('data');
            $json = json_decode($this->coder->decrypt($data));

            if (isset($json->success)) {

                if ($userData = data_get($json, 'user')) {
                    AuthTM::setUser((array)$userData);
                }

                if ($json->allowed) {
                    return $next($request);
                }

                abort(Response::HTTP_FORBIDDEN);
            }
        }

        AuthTM::logout();
        return AuthTM::login();
    }
}
