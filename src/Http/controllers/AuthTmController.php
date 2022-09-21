<?php

namespace Seshpulatov\AuthTm\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Seshpulatov\AuthTm\Helper\Coder;

class AuthTmController extends BaseController
{
    public function login(){
        $coder = new Coder();
        $json = json_decode($coder->decrypt(request()->input('data')));
        \Cache::remember($json->token, 60 * 60, function () use ($json){
            return $json->user;
        });
        return redirect(route($json->route))->withCookie(cookie()->forever(config('auth_tm.auth_session_key'), $json->token));
    }
    public function test(){
        dd('test');
    }
}
