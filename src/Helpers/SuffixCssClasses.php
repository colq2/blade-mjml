<?php

namespace colq2\BladeMjml\Helpers;

use Illuminate\Support\Str;

class SuffixCssClasses
{
    public static function suffixCssClasses(string $classes, string $suffix): string
    {
        if (empty($classes)) {
            return '';
        }

        return Str::of($classes)->explode($classes)
            ->map(fn($class) => $class . '-' . $suffix)
            ->implode(' ');
    }
}