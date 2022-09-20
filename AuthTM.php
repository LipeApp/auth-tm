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
        session()->forget(config('auth_tm.auth_session_key'));
        return self::login();
    }
}
