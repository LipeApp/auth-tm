<?php


namespace Seshpulatov\AuthTm\Http\Controllers;

\Illuminate\Support\Facades\Route::get("login", [AuthTmController::class, 'login']);
\Illuminate\Support\Facades\Route::get("logout", [AuthTmController::class, 'logout']);
\Illuminate\Support\Facades\Route::get("login-test", [AuthTmController::class, 'test']);
