<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Actch
{
    public function handle(Request $request, Closure $next)
    {

        // captcha logic (or just allow)
        //return $next($request);
        $response = $next($request);

        if ($response && method_exists($response, 'headers')) {
            $response->headers->set('Cache-Control', 'no-cache');
        }

        return $response;
    }
}
