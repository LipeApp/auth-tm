<?php

use Seshpulatov\AuthTm\Http\Controllers\AuthTmController;

$middleware = [
    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
];

Route::middleware($middleware)->group(function () {
    Route::get("login", [AuthTmController::class, 'login'])->name('auth-tm.login');
    Route::get("auth-tm/logout", [AuthTmController::class, 'logout'])->name('auth-tm.logout');
});

Route::get("api/routes", [AuthTmController::class, 'routes'])->name('auth-tm.routes');
