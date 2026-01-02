<?php

namespace App\Http\Middleware;

use Closure;

class ActivationCheckMiddleware
{
    public function handle($request, Closure $next)
    {
        // ✅ Force bypass activation check
        return $next($request);
    }
}
