<?php

namespace Seshpulatov\AuthTm\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiUserOptionalLogin extends ApiUserLogin
{
    public bool $optional = true;

    public function handle(Request $request, Closure $next, $optional = true): Response|JsonResponse|RedirectResponse
    {
        return parent::handle($request, $next, $optional);
    }
}
