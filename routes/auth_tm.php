<?php


use Seshpulatov\AuthTm\Http\Controllers\AuthTmController;

\Illuminate\Support\Facades\Route::get("login", [AuthTmController::class, 'login'])->name('tm_login');
\Illuminate\Support\Facades\Route::get("tm_logout", [AuthTmController::class, 'logout'])->name('tm_logout');
\Illuminate\Support\Facades\Route::get("api/routes", [AuthTmController::class, 'routes'])->name('tm_routes');
