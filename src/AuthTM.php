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
        return isset($_COOKIE[config('auth_tm.auth_session_key')])?\Cache::get($_COOKIE[config('auth_tm.auth_session_key')])['user']:null;
    }

    public static function menus(){
        return isset($_COOKIE[config('auth_tm.auth_session_key')])?\Cache::get($_COOKIE[config('auth_tm.auth_session_key')])['menus']:null;
    }

}
