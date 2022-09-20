<?php


use Seshpulatov\AuthTm\Controllers\AuthTmController;

\Illuminate\Support\Facades\Route::get("login", [AuthTmController::class, 'login']);
\Illuminate\Support\Facades\Route::get("login-test", [AuthTmController::class, 'test']);
