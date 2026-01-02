<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $module)
    {
        $user = Auth::user();

        if (!$user) {
            // যদি user login না থাকে
            return redirect()->route('admin.auth.login');
        }

        // Example: Check if user has permission for the module
        // তোমার বাস্তব logic অনুযায়ী পরিবর্তন করতে হবে
        if (!in_array($module, $user->modules ?? [])) {
            abort(403, 'Unauthorized: You do not have access to this module.');
        }

        return $next($request);
    }
}
