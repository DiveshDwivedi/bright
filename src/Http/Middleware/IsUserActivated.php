<?php

declare(strict_types=1);

namespace Diviky\Bright\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class IsUserActivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  null|string  $guard
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function handle($request, \Closure $next, $guard = null)
    {
        if (!Auth::guard($guard)->check()) {
            return $next($request);
        }

        $user = Auth::user();

        if (!isset($user)) {
            return $next($request);
        }

        if ($user->status == 0) {
            return redirect()->route('user.activate');
        }

        if (!empty($user->deleted_at)) {
            Auth::logout();

            abort(401, 'Account Deleted');
        }

        if ($user->status != 1) {
            Auth::logout();

            abort(401, 'Account Suspended');
        }

        return $next($request);
    }
}
