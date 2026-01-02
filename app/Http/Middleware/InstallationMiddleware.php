<?php

namespace App\Http\Middleware;

use Closure;

class InstallationMiddleware
{
    public function handle($request, Closure $next)
    {
        // ✅ Force bypass installer
        return $next($request);
    }
}
