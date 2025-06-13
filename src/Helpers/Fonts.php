<?php

namespace colq2\BladeMjml\Helpers;

class Fonts
{
    /**
     * Builds font link and style tags for importing external fonts
     *
     * @param string $content The HTML content to check for font usage
     * @param array $inlineStyle Array of inline style strings
     * @param array $fonts Map of font name to URL
     * @return string HTML for importing fonts
     */
    public static function buildFontsTags(string $content, array $inlineStyle, array $fonts = []): string
    {
        $toImport = [];


        foreach ($fonts as $name => $url) {
            $regex = '/"[^"]*font-family:[^"]*' . preg_quote($name, '/') . '[^"]*"/i';
            $inlineRegex = '/font-family:[^;}]*' . preg_quote($name, '/') . '/i';

            if (preg_match($regex, $content)) {
                $toImport[] = $url;
                continue;
            }

            foreach ($inlineStyle as $style) {
                if (preg_match($inlineRegex, $style)) {
                    $toImport[] = $url;
                    break;
                }
            }
        }

        if (count($toImport) > 0) {
            $linkTags = array_map(
                fn($url) => "<link href=\"{$url}\" rel=\"stylesheet\" type=\"text/css\">",
                $toImport
            );

            $importRules = array_map(
                fn($url) => "@import url({$url});",
                $toImport
            );

            return "
              <!--[if !mso]><!-->
                " . implode("\n", $linkTags) . "
                <style type=\"text/css\">
                  " . implode("\n", $importRules) . "
                </style>
              <!--<![endif]-->\n
            ";
        }

        return '';
    }
}