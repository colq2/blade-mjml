<?php

namespace colq2\BladeMjml\Helpers;

use Illuminate\Support\Arr;

class WidthParser
{
    protected static string $unitRegex = '/[\d.,]*(\D*)$/';

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
