<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessSetting;

class HomeController extends Controller
{
    /**
     * Home Page
     */
    public function index()
    {
        // ✅ Direct Home Page Load
        return view('home');
    }

    /**
     * Terms & Conditions
     */
    public function terms_and_conditions(Request $request)
    {
        $data = self::get_settings('terms_and_conditions');

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        return view('terms-and-conditions', compact('data'));
    }

    /**
     * About Us
     */
    public function about_us(Request $request)
    {
        $data = self::get_settings('about_us');

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        return view('about-us', compact('data'));
    }

    /**
     * Contact Us
     */
    public function contact_us()
    {
        return view('contact-us');
    }

    /**
     * Privacy Policy
     */
    public function privacy_policy(Request $request)
    {
        $data = self::get_settings('privacy_policy');

        if ($request->expectsJson()) {
            return response()->json($data);
        }

        return view('privacy-policy', compact('data'));
    }

    /**
     * Get Settings from DB
     */
    public static function get_settings($name)
    {
        $setting = BusinessSetting::where('key', $name)->first();

        if (!$setting) {
            return null;
        }

        $value = json_decode($setting->value, true);

        return $value ?? $setting->value;
    }
}
