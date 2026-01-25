<?php

namespace localization;
use watrlabs\users;

class localization
{
    private static $translations = [];
    private static $locale = 'en_US';

    public static function init(string $locale)
    {
        self::$locale = $locale;

        $file = "../storage/translations/{$locale}.json";

        self::$translations = json_decode(file_get_contents($file), true);
    }

    private static function resolve(string $key)
    {
        $parts = explode('.', $key);
        $value = self::$translations;

        foreach ($parts as $part) {
            if (!isset($value[$part])) {
                return "[$key]";
            }
            $value = $value[$part];
        }

        return $value;
    }

    public static function __callStatic($name, $arguments)
    {
        $key = str_replace('_', '.', strtolower($name));

        return self::resolve($key);
    }

    public static function get(string $key)
    {
        return self::resolve($key);
    }
}
