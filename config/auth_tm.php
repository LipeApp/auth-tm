<?php

return [
    'key'   =>  env('AUTH_SERVICE_KEY'),                    //1
    'login_url' => env('AUTH_SERVICE_URL')."/auth",         //2
    'login_check' => env('AUTH_SERVICE_URL')."/api/check",  //3
    'logout_url' => env('AUTH_SERVICE_URL')."/api/logout",  //4
    'menu_url' => env('AUTH_SERVICE_URL')."/api/menu",      //5
    'callback_url'  =>  env('APP_URL').'/login',            //6
    'auth_session_key'  =>  'this-my-auth-key',             //7
    'service_id'        =>  env('AUTH_SERVICE_ID')          //8
];
