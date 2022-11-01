<?php

namespace Seshpulatov\AuthTm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Seshpulatov\AuthTm\AuthTM;
use Seshpulatov\AuthTm\Helper\Coder;
use function Symfony\Component\Translation\t;

class AuthControl
{
    private Coder $coder;

    public function __construct()
    {
        $this->coder = new Coder();
    }

    public function handle(Request $request, Closure $next)
    {
        if (config('app.env') === 'testing'){
            return $next($request);
        }
        $value = $request->cookie(config('auth_tm.auth_session_key'));
        //dd($value);
        $hasToken = isset($_COOKIE[config('auth_tm.auth_session_key')]);
        //dd($hasToken);
        if ($hasToken === true){
            //dd('hasToken');
            $token = $_COOKIE[config('auth_tm.auth_session_key')];
            //dd($token);
            $check = Http::acceptJson()->withHeaders([
                'Authorization'=>'Bearer '.$token
            ])->post(config('auth_tm.login_check'),[
                'route' =>  Route::currentRouteName(),
                'service_id'=>config('auth_tm.service_id')
            ]);
            if ($check->status() === 401)
                return AuthTM::logout();

            $coder = new Coder();
            if (is_array($check->json('data'))){
                exit("Auth Controller");
            }
            $json = json_decode($coder->decrypt($check->json('data')));

            if (isset($json->success)){ // && $json->expires_at < time()
                if ($json->allowed){
                    return $next($request);
                }else{
                    abort(403);
                }
            }else{
                return AuthTM::logout();
            }
        }else{
            AuthTM::logout();
            return AuthTM::login();
        }
        return $next($request);
    }
}
