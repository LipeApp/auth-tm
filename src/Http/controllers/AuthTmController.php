<?php

namespace Seshpulatov\AuthTm\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class AuthTmController extends BaseController
{
    public function login(){
        $json = decrypt(request()->input('data'));
        dd($json);
    }
    public function test(){
        dd('test');
    }
}
