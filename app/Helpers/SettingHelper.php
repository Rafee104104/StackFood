<?php

namespace App\Helpers;

use App\Models\BusinessSetting;

class SettingHelper
{
    public static function get($key, $default = null)
    {
        return optional(
            BusinessSetting::where('key', $key)->first()
        )->value ?? $default;
    }

    public static function set($key, $value)
    {
        BusinessSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}
