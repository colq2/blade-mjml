<?php

namespace colq2\BladeMjml\Helpers;

use Illuminate\Support\Arr;

class WidthParser
{
    protected static string $unitRegex = '/[\d.,]*(\D*)$/';

    /**
     * Parses a width value and returns its numeric value and unit.
     *
     * @param  mixed  $width  The width value to parse (string, int, float, or object with toString()).
     * @param  array{parseFloatToInt?: bool}  $options  Options for parsing (default: ['parseFloatToInt' => true]).
     * @return array{parsedWidth: int|float, unit: string} The parsed width and its unit.
     */
    public static function widthParser(mixed $width, array $options = []): array
    {
        $parseFloatToInt = Arr::get($options, 'parseFloatToInt', true);

        $widthStr = is_object($width) && method_exists($width, 'toString')
            ? $width->toString()
            : (string) $width;

        $matches = [];
        preg_match(static::$unitRegex, $widthStr, $matches);
        $widthUnit = $matches[1] ?? '';

        $parseInt = fn ($v) => (int) $v;
        $parseFloat = fn ($v) => (float) $v;
        $parser = match ($widthUnit) {
            'px' => $parseInt,
            '%' => $parseFloatToInt ? $parseInt : $parseFloat,
            default => $parseInt,
        };

        return [
            'parsedWidth' => $parser($widthStr),
            'unit' => $widthUnit ?: 'px',
        ];
    }
}
