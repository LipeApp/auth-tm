<?php

namespace Seshpulatov\AuthTm\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\Response as HttpClientResponse;
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
    public function __construct(protected Coder $coder)
    {
    }

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

        if ($token = AuthTM::getToken()) {

            $response = $this->checkLogin($token);

            if ($response->status() === Response::HTTP_UNAUTHORIZED) {
                return AuthTM::login();
            }

            $json = $this->normalizeResponseData($response);

            if (isset($json['success'])) {

                $success = $json['success'];

                if ($success) {

                    if (isset($json['allowed'])) {

                        $allowed = (bool)$json['allowed'];

                        if ($allowed) {
                            if ($userData = data_get($json, 'user')) {
                                AuthTM::setUser((array)$userData);
                            }
                            return $next($request);
                        } else {
                            abort(Response::HTTP_FORBIDDEN);
                        }
                    }
                }
            }

        }

        AuthTM::logout();
        return AuthTM::login();
    }

    /**
     * @param string $token
     * @return HttpClientResponse
     */
    protected function checkLogin($token): HttpClientResponse
    {
        return Http::acceptJson()
            ->withToken($token)
            ->post(config('auth-tm.login_check'), [
                'route'      => Route::currentRouteName(),
                'service_id' => config('auth-tm.service_id')
            ]);
    }

    /**
     * @param HttpClientResponse $response
     * @return array
     */
    private function normalizeResponseData(HttpClientResponse $response): array
    {

        $json = $response->json();

        if (!is_array($json)) {
            return [];
        }

        if (isset($json['success'])) {
            return $json;
        }

        if (isset($json['data']) && is_string($json['data'])) {

            $data = $json['data'];
            return json_decode($this->coder->decrypt($data), true);
        }

        return [];
    }
}
