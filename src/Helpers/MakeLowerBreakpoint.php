<?php

declare(strict_types=1);

namespace colq2\BladeMjml\Helpers;

final class MakeLowerBreakpoint
{
    /**
     * Returns the breakpoint minus 1 pixel, e.g. "600px" -> "599px".
     * If parsing fails, returns the original string.
     *
     * @param string $breakpoint
     * @return string
     */
    public static function makeLowerBreakpoint(string $breakpoint): string
    {
        if (preg_match('/(\d+)/', $breakpoint, $matches)) {
            $pixels = (int) $matches[1];
            return ($pixels - 1) . 'px';
        }
        return $breakpoint;
    }
}