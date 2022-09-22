<?php

return [
    'key'   =>  env('AUTH_SERVICE_ID'),
    'login_url' => env('AUTH_SERVICE_URL')."/auth",
    'login_check' => env('AUTH_SERVICE_URL')."/api/check",
    'logout_url' => env('AUTH_SERVICE_URL')."/api/logout",
    'menu_url' => env('AUTH_SERVICE_URL')."/api/menu",
    'callback_url'  =>  env('APP_URL').'/login',
    'auth_session_key'  =>  'this-my-auth-key',
    'service_id'        =>  env('AUTH_SERVICE_ID')
];
