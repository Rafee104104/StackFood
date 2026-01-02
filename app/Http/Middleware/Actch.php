<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Actch
{
    public function handle(Request $request, Closure $next)
    {
        // captcha logic (or just allow)
        return $next($request);
    }
}
