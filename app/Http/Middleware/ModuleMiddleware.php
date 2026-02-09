<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BusinessSetting;

class ModuleMiddleware
{
    public function handle(Request $request, Closure $next, $module)
    {
        /**
         * ======================
         * VENDOR PANEL
         * ======================
         */
        if (Auth::guard('vendor')->check()) {
            $vendor = Auth::guard('vendor')->user();

            if ($vendor->status != 1) {
                abort(403);
            }

            $vendorAllowedModules = [
                'item',
                'order',
                'category',
                'campaign',
                'pos',
                'employee',
                'custom_role',
                'store',
                'business_settings',
                'wallet',
                'profile',
            ];

            if (!in_array($module, $vendorAllowedModules)) {
                abort(403);
            }

            return $next($request);
        }

        /**
         * ======================
         * ADMIN PANEL
         * ======================
         */
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();

            // super admin
            if ($admin->role_id == 1) {
                return $next($request);
            }

            // check module enabled
            $setting = BusinessSetting::where('key', $module)->first();
            if ($setting && (string) $setting->value === '1') {
                return $next($request);
            }

            abort(403);
        }

        abort(403);
    }
}
