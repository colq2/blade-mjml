<?php

namespace colq2\BladeMjml\Helpers;

class StyleBuilder
{
    public static function build(array $styles, string $lineSeparator = ''): string
    {
        $style = '';
        foreach ($styles as $key => $value) {
            // skip empty values
            if (empty($value)) {
                continue;
            }

            if (is_array($value)) {
                $style .= static::build($value);
            } else {
                $style .= "$key:$value;".$lineSeparator;
            }
        }

        return $style;
    }
}
