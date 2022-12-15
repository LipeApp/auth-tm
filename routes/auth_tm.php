<?php


use Seshpulatov\AuthTm\Http\Controllers\AuthTmController;

Route::middleware('web')->group(function () {
    Route::get("login", [AuthTmController::class, 'login'])->name('auth-tm.login');
    Route::get("auth-tm/logout", [AuthTmController::class, 'logout'])->name('auth-tm.logout');
});

Route::get("api/routes", [AuthTmController::class, 'routes'])->name('auth-tm.routes');
