<?php

return [
    'key' => env('AUTH_SERVICE_KEY'),
    'login_url' => env('AUTH_SERVICE_URL') . "/auth",
    'login_check' => env('AUTH_SERVICE_URL') . "/api/check",
    'logout_url' => env('AUTH_SERVICE_URL') . "/api/logout",
    'menu_url' => env('AUTH_SERVICE_URL') . "/api/menu",
    'callback_url' => env('APP_URL') . '/auth-tm/login',
    'auth_session_key' => 'this-my-auth-key',
    'service_id' => env('AUTH_SERVICE_ID'),
    'after_login_url' => env('AUTH_SERVICE_AFTER_LOGIN_URL', '/home'),
    'after_logout_url' => env('AUTH_SERVICE_AFTER_LOGOUT_URL', '/'),
];
