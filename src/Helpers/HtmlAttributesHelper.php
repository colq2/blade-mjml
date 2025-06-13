<?php

namespace colq2\BladeMjml\Helpers;

class HtmlAttributesHelper
{
    /**
     * Checks if a value is nil (null or undefined in JS terms).
     *
     * @param  mixed  $value  The value to check.
     * @return bool True if the value is nil, false otherwise.
     */
    public static function isNil($value): bool
    {
        return $value === null || $value === '';
    }

    /**
     * Identity function, returns the value unchanged.
     *
     * @param  mixed  $value  The value to return.
     * @return mixed The unchanged value.
     */
    public static function identity($value)
    {
        return $value;
    }

    /**
     * Filter an array by removing nil values.
     *
     * @param  array  $array  The array to filter.
     * @return array The filtered array.
     */
    public static function omitNil(array $array): array
    {
        return array_filter($array, function ($value) {
            return ! self::isNil($value);
        });
    }

    /**
     * Get a property from an object by path.
     *
     * @param  array|object  $object  The object to get the property from.
     * @param  string  $path  The property path.
     * @param  mixed  $default  The default value if the property doesn't exist.
     * @return mixed The property value.
     */
    public static function get($object, string $path, $default = null): mixed
    {
        if (is_array($object)) {
            return $object[$path] ?? $default;
        } elseif (is_object($object)) {
            return $object->{$path} ?? $default;
        }
    }
}
