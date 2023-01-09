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
     * @var User|null
     */
    public static $user;

    /**
     * @return mixed
     */
    public static function getCookieKey()
    {
        return config('auth-tm.auth_session_key');
    }

    /**
     * @return string|null
     */
    public static function getToken()
    {
        return Cookie::get(self::getCookieKey());
    }

    /**
     * @return bool
     */
    public static function hasToken(): bool
    {
        return is_null(!self::getToken());
    }

    /**
     * @return Redirector|Application|RedirectResponse
     */
    public static function login()
    {
        return redirect(config('auth-tm.login_url')
            . "?callback_url=" . config('auth-tm.callback_url')
            . "&route=" . Route::currentRouteName()
            . "&service_id=" . config('auth-tm.service_id'));
    }

    /**
     * @return void
     */
    public static function logout()
    {

        $token = self::getToken();
        if ($token) {
            Http::acceptJson()
                ->withToken($token)
                ->post(config('auth-tm.logout_url'), [
                    'token' => $token
                ]);
        }

        AuthTM::forgetCookie();
        AuthTM::removeUser();

    }

    /**
     * @return void
     */
    public static function forgetCookie()
    {
        $cookie = Cookie::forever(AuthTM::getCookieKey(), null);
        Cookie::queue($cookie);
    }

    /**
     * @return User|null
     */
    public static function user(): ?User
    {
        return self::$user;
    }

    /**
     * @return bool
     */
    public static function hasUser(): bool
    {
        return !is_null(self::user());
    }

    /**
     * @return int|null
     */
    public static function userId()
    {
        if (self::hasUser()) {
            return self::user()->id;
        } else {
            return null;
        }
    }

    /**
     * @return string|null
     */
    public static function userFullName()
    {
        if (self::hasUser()) {
            return self::user()->full_name;
        } else {
            return null;
        }
    }

    /**
     * @param array $userData
     */
    public static function setUser(array $userData): void
    {
        $user = new User($userData);
        self::$user = $user;
    }

    /**
     * @return void
     */
    public static function removeUser()
    {
        self::$user = null;
    }

    /**
     * @return array|mixed
     */
    public static function getMenu()
    {

        $token = self::getToken();

        if (!empty($token)) {

            return Cache::remember($token . "_menu", 60 * 24, function () use ($token) {

                $serviceId = config('auth-tm.service_id');
                $url = config('auth-tm.menu_url') . '?service_id=' . $serviceId;
                $result = Http::acceptJson()
                    ->withToken($token)
                    ->get($url);

                $json = json_decode($result);

                return $json->menus;
            });
        }

        return [];
    }

}
