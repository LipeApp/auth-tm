<?php


use Seshpulatov\AuthTm\Http\Controllers\AuthTmController;

\Illuminate\Support\Facades\Route::get("auth-tm/login", [AuthTmController::class, 'login'])->name('auth-tm.login');
\Illuminate\Support\Facades\Route::get("auth-tm/logout", [AuthTmController::class, 'logout'])->name('auth-tm.logout');
\Illuminate\Support\Facades\Route::get("api/routes", [AuthTmController::class, 'routes'])->name('auth-tm.routes');
