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
    public static function getCookieKey()
    {
        return config('auth_tm.auth_session_key');
    }

    /**
     * @return string|null
     */
    public static function getToken()
    {
        return Cookie::get(self::getCookieKey());
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
        $token = self::getToken();

        if ($token) {
            Http::acceptJson()
                ->withToken($token)
                ->post(config('auth_tm.logout_url'), [
                    'token' => $token
                ]);
        }

        Cache::forget(config($key . '_user'));
        $cookie = Cookie::forever(AuthTM::getCookieKey(), null);
        Cookie::queue($cookie);

    }

    /**
     * @return array|mixed
     */
    public static function user()
    {
        $token = self::getToken();
        return Cache::get($token . '_user', []);
    }


}
