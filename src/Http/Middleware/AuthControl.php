<?php

namespace Seshpulatov\AuthTm\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Seshpulatov\AuthTm\AuthTM;
use function Symfony\Component\Translation\t;

class AuthControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $value = $request->cookie(config('auth_tm.auth_session_key'));
        //dd($value);
        $hasToken = isset($_COOKIE[config('auth_tm.auth_session_key')]);
        //dd($hasToken);
        if ($hasToken === true){
            //dd('hasToken');
            $token = $_COOKIE[config('auth_tm.auth_session_key')];
            $json = Http::acceptJson()->withHeaders([
                'Authorization'=>'Bearer '.$token
            ])->post(config('auth_tm.login_check'),[
                'route' =>  Route::currentRouteName(),
                'service_id'=>config('auth_tm.service_id')
            ])->json();
            if (isset($json['success'])){
                if ($json['allowed']){
                    return $next($request);
                }else{
                    abort(403);
                }
            }else{
                AuthTM::logout();
                return AuthTM::login();
            }
        }else{
            AuthTM::logout();
            return AuthTM::login();
        }
        return $next($request);
    }
}
