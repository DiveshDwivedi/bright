<?php

namespace Karla\Middlewares;

use Closure;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->add(['Accept' => 'application/json']);
        //app('is_api_request', true);

        return $next($request);
    }
}
