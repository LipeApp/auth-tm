<?php

namespace Seshpulatov\AuthTm;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class AuthTM
{
    /**
     * @var User|null
     */
    public static ?User $user = null;

    /**
     * @return mixed
     */
    public static function getCookieKey(): mixed
    {
        return config('auth-tm.auth_session_key');
    }


    /**
     * @return array|string|null
     */
    public static function getToken(): array|string|null
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
    public static function login(): Redirector|RedirectResponse|Application
    {
        return redirect(config('auth-tm.login_url')
            . "?callback_url=" . config('auth-tm.callback_url')
            . "&route=" . Route::currentRouteName()
            . "&service_id=" . config('auth-tm.service_id'));
    }

    /**
     * @return void
     */
    public static function logout(): void
    {
        if ( $token = self::getToken() ) {
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
    public static function forgetCookie(): void
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
    public static function userId(): ?int
    {
        return self::user()?->id;
    }

    /**
     * @return string|null
     */
    public static function userFullName(): ?string
    {
       return self::user()?->full_name;
    }

    /**
     * @param array $userData
     */
    public static function setUser(array $userData): void
    {
        self::$user = (new User($userData));
    }

    /**
     * @return void
     */
    public static function removeUser(): void
    {
        self::$user = null;
    }

    /**
     * @return array|mixed
     */
    public static function getMenu(): mixed
    {
        $token = self::getToken();

        if (!empty($token)) {

            return Cache::remember($token . "_menu", 60 * 24, function () use ($token) {

                $url    = config('auth-tm.menu_url') . '?service_id=' . config('auth-tm.service_id');
                $result = Http::acceptJson()
                            ->withToken($token)
                            ->get($url);

                $json = json_decode($result);
                return $json?->menus;
            });
        }

        return [];
    }

}
