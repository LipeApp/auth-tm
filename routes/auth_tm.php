<?php


use Seshpulatov\AuthTm\Controllers\AuthTmController;

\Illuminate\Support\Facades\Route::get("login", [AuthTmController::class, 'login']);
