<?php

namespace Seshpulatov\AuthTm\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Seshpulatov\AuthTm\AuthTM;

/**
 * API so'rovlarida (asosan gatewaydan keladi) userni id bo'yicha
 * login qilish.
 * User id qiymati headerda 'user-id' nomi bilan keladi.
 *
 */
class ApiUserLogin
{

    /**
     * Agar true bo'lsa, user login bo'lmasa ham keyingi qadamga o'tib ketadi.
     * @var bool
     */
    public bool $optional = false;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param bool $optional
     * @return Response|RedirectResponse|JsonResponse
     */
    public function handle(Request $request, Closure $next, $optional = false): Response|JsonResponse|RedirectResponse
    {

        $this->optional = (bool)$optional;
        $userId = $request->header('user-id');

        if (empty($userId)) {
            if (!$this->optional) {

                /**
                 * Agar user_id bo'lmasa va $optional=false bo'lsa
                 * demak userga ruxsat mavjud emas, 401 qaytaradi.
                 **/
                abort(401, 'Unathorized user');
            }
        } else {

            /**
             * Aks holda AuthTM ga user id bo'yicha login qilamiz
             * @see AuthTM::userId()
             **/
            AuthTM::setUser(['id' => $userId]);
        }

        return $next($request);
    }

}
