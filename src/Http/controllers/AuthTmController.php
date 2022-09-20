<?php

namespace Seshpulatov\AuthTm\Controllers;

use App\Http\Controllers\Controller;

class AuthTmController extends Controller
{
    public function login(){
        $json = encrypt(request()->input('data'));
        dd($json);
    }
    public function test(){
        dd('test');
    }
}
