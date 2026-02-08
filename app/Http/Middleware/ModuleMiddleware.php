<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\BusinessSetting;
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

    public function handle($request, Closure $next, $module)
{
    $admin = auth('admin')->user();

    if (!$admin) {
        abort(403);
    }

    // SUPER ADMIN BYPASS
    if ($admin->role_id == 1) {
        return $next($request);
    }

    $setting = BusinessSetting::where('key', $module)->first();

    if (!$setting || $setting->value != 1) {
        abort(403);
    }

    abort(403); // other roles blocked for now
}


}
