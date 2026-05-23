<?php

namespace App\Helpers;

class I18n
{
    private static $translations = [];
    private static $locale = 'ru';

    public static function load($locale = null)
    {
        if (!$locale) {
            $locale = $_COOKIE['lang'] ?? 'ru';
        }

        if (!in_array($locale, ['ru', 'kk'])) {
            $locale = 'ru';
        }

        self::$locale = $locale;
        $file = __DIR__ . '/../../lang/' . $locale . '.json';

        if (file_exists($file)) {
            $content = file_get_contents($file);
            self::$translations = json_decode($content, true) ?: [];
        } else {
            self::$translations = [];
        }
    }

    public static function translate($key)
    {
        return self::$translations[$key] ?? $key;
    }

    public static function getLocale()
    {
        return self::$locale;
    }
}
