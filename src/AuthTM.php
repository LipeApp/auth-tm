<?php

namespace Seshpulatov\AuthTm;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

class AuthTM
{

    public static function check(){

    }
    public static function login(): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse
    {
        return redirect(config('auth_tm.login_url')
            ."?callback_url=".config('auth_tm.callback_url')
            ."&route=" .Route::currentRouteName()
            ."&service_id=".config('auth_tm.service_id'));
    }

    public static function logout(){
        if (isset($_COOKIE[config('auth_tm.auth_session_key')]))
        {
            Http::acceptJson()->withHeaders([
                'Authorization'=>'Bearer '.$_COOKIE[config('auth_tm.auth_session_key')]
            ])->post(config('auth_tm.logout_url'),[
                'token'=>$_COOKIE[config('auth_tm.auth_session_key')]
            ]);
            unset($_COOKIE[config('auth_tm.auth_session_key')]);
            setcookie(config('auth_tm.auth_session_key'), null, -1, '/');
        }

        return redirect("/home");
    }

    public static function getToken(): string|null
    {
        return request()->cookie(config('auth_tm.auth_session_key'));
    }

    public static function user(){
        return isset($_COOKIE[config('auth_tm.auth_session_key')."_user"])?\Cache::get($_COOKIE[config('auth_tm.auth_session_key')]):null;
    }

    public static function getMenu(){
        if (isset($_COOKIE[config('auth_tm.auth_session_key')]))
        {
            return \Cache::remember($_COOKIE[config('auth_tm.auth_session_key')]."_menu", 60 * 24 * 7, function () {
                $json = json_decode(Http::acceptJson()
                    ->withHeaders(['Authorization'=>'Bearer '.$_COOKIE[config('auth_tm.auth_session_key')]])
                    ->get(config('auth_tm.menu_url')));

                return $json->menus;
            });
        }
        return [];
    }
}
