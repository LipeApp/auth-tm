<?php

use App\Http\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Seshpulatov\AuthTm\Http\Controllers\AuthTmController;

$middleware = [
    EncryptCookies::class,
    AddQueuedCookiesToResponse::class,
    StartSession::class,
    ShareErrorsFromSession::class,
];

Route::middleware($middleware)->group(function () {
    Route::get("auth-tm/login", [AuthTmController::class, 'login'])->name('auth-tm.login');
    Route::get("auth-tm/logout", [AuthTmController::class, 'logout'])->name('auth-tm.logout');
});

Route::get("api/routes", [AuthTmController::class, 'routes'])->name('auth-tm.routes');
