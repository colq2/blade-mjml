<?php

namespace colq2\BladeMjml\Helpers;

class ShorthandParser
{
    /**
     * Parse CSS shorthand values like margin or padding.
     *
     * @param  string  $cssValue  The CSS shorthand value.
     * @param  string  $direction  The direction (top, right, bottom, left).
     * @return int The parsed value.
     */
    public static function parse(string $cssValue, string $direction): int
    {
        $cssValue = trim($cssValue);
        $cssValue = preg_replace('/\s+/', ' ', $cssValue);
        $splittedCssValue = explode(' ', $cssValue, 4);
        $directions = [];

        switch (count($splittedCssValue)) {
            case 2:
                $directions = ['top' => 0, 'bottom' => 0, 'left' => 1, 'right' => 1];
                break;

            case 3:
                $directions = ['top' => 0, 'left' => 1, 'right' => 1, 'bottom' => 2];
                break;

            case 4:
                $directions = ['top' => 0, 'right' => 1, 'bottom' => 2, 'left' => 3];
                break;

            case 1:
            default:
                return intval($cssValue);
        }

        return intval($splittedCssValue[$directions[$direction]] ?? 0);
    }

    /**
     * Parse border shorthand values.
     *
     * @param  string  $border  The border shorthand value.
     * @return int The parsed border width.
     */
    public static function parseBorder(string $border): int
    {
        if (preg_match('/(?:(?:^| )(\d+))/', $border, $matches)) {
            return (int) $matches[1];
        }

        return 0;
    }
}
