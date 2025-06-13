<?php

namespace colq2\BladeMjml\Helpers;

class Styles
{
    /**
     * Builds style from components head styles and head styles object
     *
     * @param string $breakpoint The responsive breakpoint
     * @param array $componentsHeadStyles Array of component style functions
     * @param array $headStylesObject Object of head styles
     * @return string HTML style tag with compiled styles
     */
    public static function buildStyleFromComponents(
        string $breakpoint,
        array $componentsHeadStyles,
        array $headStylesObject
    ): string {
        $headStyles = array_values($headStylesObject);

        if (count($componentsHeadStyles) === 0 && count($headStyles) === 0) {
            return '';
        }

        $allStyles = array_merge($componentsHeadStyles, $headStyles);
        $combinedStyles = array_reduce(
            $allStyles,
            function (string $result, $styleFunction) use ($breakpoint) {
                return $result . "\n" . $styleFunction($breakpoint);
            },
            ''
        );

        return "
    <style type=\"text/css\">{$combinedStyles}
    </style>";
    }

    /**
     * Builds style from style tags
     *
     * @param string $breakpoint The responsive breakpoint
     * @param array $styles Array of style strings or functions
     * @return string HTML style tag with compiled styles
     */
    public static function buildStyleFromTags(string $breakpoint, array $styles): string
    {
        if (count($styles) === 0) {
            return '';
        }

        $combinedStyles = array_reduce(
            $styles,
            function (string $result, $style) use ($breakpoint) {
                $styleContent = is_callable($style) ? $style($breakpoint) : $style;
                return $result . "\n" . $styleContent;
            },
            ''
        );

        return "
        <style type=\"text/css\">{$combinedStyles}
        </style>";
    }
}