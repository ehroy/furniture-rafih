<?php
namespace App\Helpers;

use Illuminate\Support\Facades\File;

class SettingsHelper
{
    protected static $filePath = __DIR__.'/settings.json';

    public static function getSettings()
    {
        if (!File::exists(self::$filePath)) {
            return [];
        }

        return json_decode(File::get(self::$filePath), true);
    }

    public static function saveSettings(array $settings)
    {
        File::put(self::$filePath, json_encode($settings, JSON_PRETTY_PRINT));
    }
}
