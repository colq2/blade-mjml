<?php

namespace colq2\BladeMjml\Helpers;

class MediaQueries
{
    /**
     * Generates the media query tags based on the defined breakpoints and media queries.
     *
     * @param  string  $breakpoint  The breakpoint value (e.g. '480px')
     * @param  array  $mediaQueries  An array of media queries
     * @param  array  $options  Optional settings
     * @return string The generated media query CSS tags
     */
    public static function buildMediaQueriesTags(
        string $breakpoint = '480px',
        array $mediaQueries = [],
        array $options = []
    ): string {
        if (empty($mediaQueries)) {
            return '';
        }

        $forceOWADesktop = $options['forceOWADesktop'] ?? false;
        $printerSupport = $options['printerSupport'] ?? false;

        // Base media queries for standard browsers
        $baseMediaQueries = [];
        foreach ($mediaQueries as $className => $mediaQuery) {
            $baseMediaQueries[] = ".{$className} {$mediaQuery}";
        }

        // Thunderbird-specific media queries
        $thunderbirdMediaQueries = [];
        foreach ($mediaQueries as $className => $mediaQuery) {
            $thunderbirdMediaQueries[] = ".moz-text-html .{$className} {$mediaQuery}";
        }

        // OWA (Outlook Web App) specific queries
        $owaQueries = [];
        foreach ($baseMediaQueries as $mq) {
            $owaQueries[] = "[owa] {$mq}";
        }

        // Combine the media queries
        $output = "
    <style type=\"text/css\">
      @media only screen and (min-width:{$breakpoint}) {
        ".implode("\n        ", $baseMediaQueries)."
      }
    </style>
    <style media=\"screen and (min-width:{$breakpoint})\">
      ".implode("\n      ", $thunderbirdMediaQueries).'
    </style>';

        // Add printer support if enabled
        if ($printerSupport) {
            $output .= '
    <style type="text/css">
      @media only print {
        '.implode("\n        ", $baseMediaQueries).'
      }
    </style>';
        }

        // Force OWA Desktop if enabled
        if ($forceOWADesktop) {
            $output .= '
    <style type="text/css">
      '.implode("\n      ", $owaQueries).'
    </style>';
        }

        return $output;
    }

    /**
     * Adds a media query to a collection.
     *
     * @param  array  $mediaQueries  Existing media queries
     * @param  string  $className  The class name
     * @param  array  $options  Options for the media query
     * @return array The updated media queries collection
     */
    public static function addMediaQuery(array $mediaQueries, string $className, array $options): array
    {
        $parsedWidth = $options['parsedWidth'] ?? 0;
        $unit = $options['unit'] ?? 'px';

        $mediaQueries[$className] = "{ width:{$parsedWidth}{$unit} !important; max-width: {$parsedWidth}{$unit}; }";

        return $mediaQueries;
    }
}
