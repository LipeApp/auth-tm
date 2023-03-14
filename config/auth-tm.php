<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Secret key to encrypt/decrypt the data with SSO.
    |--------------------------------------------------------------------------
    */

    'key' => env('AUTH_SERVICE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Login url on SSO
    |--------------------------------------------------------------------------
    |
    */

    'login_url' => env('AUTH_LOGIN_URL'),

    /*
    |--------------------------------------------------------------------------
    | Login check url on SSO
    |--------------------------------------------------------------------------
    |
    | Ushbu url AuthControlMiddlewareda ishlatiladi.
    | Foydalanuvchi har bir sahifaga kirganda, agar cookieda token
    | mavjud bo'lsa, SSO dagi ushbu urlga murojaat qiladi. Agar SSO dan
    | allowed=true response kelsa, user ushbu sahifaga kirishi mumkin.
    |
    */

    'login_check' => env('AUTH_LOGIN_CHECK_URL'),

    /*
    |--------------------------------------------------------------------------
    | Logout url on SSO
    |--------------------------------------------------------------------------
    |
    */

    'logout_url' => env('AUTH_SERVICE_URL') . "/api/logout",

    /*
    |--------------------------------------------------------------------------
    | Menu url on SSO
    |--------------------------------------------------------------------------
    |
    | Userga ruxsat berilgan routelar ro'yxatini qaytaradi
    |
    */

    'menu_url' => env('AUTH_SERVICE_URL') . "/api/menu",

    /*
    |--------------------------------------------------------------------------
    | Login url on this application
    |--------------------------------------------------------------------------
    |
    | SSO dan login bo'lgandan keyin, userning ma'lumotlari shu
    | urlga qaytadi. Bu yerdan user login qilinadi.
    |
    */

    'callback_url' => env('APP_URL') . '/auth-tm/login',

    /*
    |--------------------------------------------------------------------------
    | Key for Authentication token
    |--------------------------------------------------------------------------
    |
    | The auth token will be stored in cookie with this name.
    */

    'auth_session_key' => 'this-my-auth-key',

    /*
    |--------------------------------------------------------------------------
    | Microservice identification key
    |--------------------------------------------------------------------------
    */

    'service_id' => env('AUTH_SERVICE_ID'),

    /*
    |--------------------------------------------------------------------------
    | Url to redirect after login
    |--------------------------------------------------------------------------
    |
    | Login bo'lgandan keyin responseda kelgan route ushbu applicationda
    | bo'lmasa, ushbu urlga redirect qilib yuboradi. Odatda bu home page
    | bo'lishi tavsiya qilinadi.
    |
    */

    'after_login_url' => env('AUTH_SERVICE_AFTER_LOGIN_URL', '/home'),

    /*
    |--------------------------------------------------------------------------
    | Url to redirect after logout
    |--------------------------------------------------------------------------
    |
    | Logout bo'lgandan keyin, ushbu urlga redirect qilib yuboradi.
    | Odatda bu url login talab qilmaydigan url bo'lishi kerak.
    |
    */
    'after_logout_url' => env('AUTH_SERVICE_AFTER_LOGOUT_URL', '/'),


    /*
    |--------------------------------------------------------------------------
    | Documentation url.
    |--------------------------------------------------------------------------
    |
    | Default page sahifasidagi "documentation" tugmasi uchun url.
    |
    */

    'documentation_url' => "#",

    /*
    |--------------------------------------------------------------------------
    | Administration home page url.
    |--------------------------------------------------------------------------
    |
    | Default page sahifasidagi Administrator paneliga o'tish uchun url.
    |
    */
    'home_page_url' => "/home",
];
