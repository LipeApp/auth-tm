<?php

namespace Seshpulatov\AuthTm;

use Cache;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class AuthTM
{

    /**
     * @return mixed
     */
    public static function authSessionKey()
    {
        return config('auth_tm.auth_session_key');
    }

    public static function authTmCookieToken()
    {
        return $_COOKIE[(self::authSessionKey())] ?? null;
    }

    /**
     * @return Redirector|Application|RedirectResponse
     */
    public static function login()
    {
        return redirect(config('auth_tm.login_url')
            . "?callback_url=" . config('auth_tm.callback_url')
            . "&route=" . Route::currentRouteName()
            . "&service_id=" . config('auth_tm.service_id'));
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public static function logout()
    {

        $key = config('auth_tm.auth_session_key');

        if (request()->hasCookie($key)) {

            $token = request()->cookie($key);

            Http::acceptJson()
                ->withToken($token)
                ->post(config('auth_tm.logout_url'), [
                    'token' => $token
                ]);

            Cookie::forget($key);
        }

        return redirect(config('auth_tm.default_url'));
    }

    /**
     * @return string|null
     */
    public static function getToken(): string|null
    {
        return request()->cookie(config('auth_tm.auth_session_key'));
    }

    /**
     * @return array|mixed
     */
    public static function user()
    {
        if (isset($_COOKIE[config('auth_tm.auth_session_key')])) {
            return Cache::get($_COOKIE[config('auth_tm.auth_session_key')] . '_user') ?? [];
        }
        return [];
    }


}
