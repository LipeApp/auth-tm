<?php


namespace Seshpulatov\AuthTm\Http\Controllers;

\Illuminate\Support\Facades\Route::get("login", [AuthTmController::class, 'login'])->name('tm_login');
\Illuminate\Support\Facades\Route::get("logout", [AuthTmController::class, 'logout'])->name('tm_logout');
\Illuminate\Support\Facades\Route::get("login-test", [AuthTmController::class, 'test']);
