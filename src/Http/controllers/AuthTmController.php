<?php

namespace Seshpulatov\AuthTm\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Seshpulatov\AuthTm\Helper\Coder;

class AuthTmController extends BaseController
{
    public function login(){
        $coder = new Coder();
        $json = $coder->decrypt(request()->input('data'));
        dd($json);
        return 1;
    }
    public function test(){
        dd('test');
    }
}
