<?php

return [
    'key'   =>  env('AUTH_SERVICE_ID'),
    'login_url' => env('AUTH_SERVICE_URL'),
    'callback_url'  =>  env('APP_URL').'/login',
    'auth_session_key'  =>  'this-my-auth-key',
    'service_id'        =>  env('AUTH_SERVICE_ID')
];
