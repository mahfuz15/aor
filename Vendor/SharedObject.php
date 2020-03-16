<?php
namespace Vendor;

use Exception;

class SharedObject
{

    protected static $instances;

    public static function has(string $key)
    {
        return isset(self::$instances[$key]);
    }

    public static function get(string $key)
    {
        if (self::has($key)) {
            return self::$instances[$key];
        }

        throw new Exception($key . ' not found in shared state !');
    }

    public static function set($key, $object)
    {
        return self::$instances[$key] = $object;
    }
}
