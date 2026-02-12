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
                'my_shop',
                'business_settings',
                'store_setup',
                'wallet',
                'profile',
                'bank_info',
                'reviews'
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

            // Super Admin
            if ($admin->role_id == 1) {
                return $next($request);
            }

            $path = trim($request->path(), 'admin/');

            $adminAllowedModules = [

                // Delivery Man
                'delivery_man' => [
                    'delivery-man/list',
                    'delivery-man/add',
                    'delivery-man/reviews/list',
                ],

                // Addon
                'addon' => [
                    'addon/bulk-export',
                    'addon/bulk-import',
                    'addon/add-new',
                ],

                // Product Basics
                'unit' => ['unit'],
                'attribute' => ['attribute/add-new'],

                // Zone
                'zone' => ['zone'],

                // Parcel
                'parcel' => [
                    'parcel/settings',
                    'parcel/orders',
                    'parcel/category',
                ],

                // Module Management
                'module' => [
                    'module',
                    'module/create',
                ],

                // Customer
                'customer' => ['customer/list'],

                // Marketing
                'banner' => ['banner/add-new'],
                'coupon' => ['coupon/add-new'],
                'notification' => ['notification/add-new'],

                // Vendor Finance
                'vendor_withdraw' => ['vendor/withdraw_list'],
                'account_transaction' => ['account-transaction'],
                'deliveryman_earning' => ['provide-deliveryman-earnings'],

                // Business Settings
                'business_settings' => [
                    'business-settings/business-setup',
                    'business-settings/social-media',
                    'business-settings/payment-method',
                    'business-settings/mail-config',
                    'business-settings/sms-module',
                    'business-settings/fcm-index',
                    'business-settings/app-settings',
                    'business-settings/landing-page-settings/index',
                    'business-settings/config-setup',
                    'business-settings/recaptcha',
                    'business-settings/db-index',
                ],

                // CMS Pages
                'pages' => [
                    'business-settings/pages/terms-and-conditions',
                    'business-settings/pages/privacy-policy',
                    'business-settings/pages/about-us',
                ],

                // Reports
                'report' => [
                    'report/day-wise-report',
                    'report/item-wise-report',
                ],
            ];

            foreach ($adminAllowedModules as $moduleKey => $routes) {

                foreach ($routes as $route) {
                    if (str_starts_with($path, $route)) {

                        // module enabled check from DB
                        $setting = BusinessSetting::where('key', $moduleKey)->first();

                        if ($setting && (string) $setting->value === '1') {
                            return $next($request);
                        }

                        abort(403);
                    }
                }
            }

            abort(403);
        }
    }
}
