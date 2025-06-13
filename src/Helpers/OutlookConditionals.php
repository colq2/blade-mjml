<?php

namespace colq2\BladeMjml\Helpers;

class OutlookConditionals
{
    /**
     * Minify content inside Outlook conditional comments
     *
     * Removes unnecessary whitespace between tags within conditional comments
     * while preserving the structure and content.
     *
     * @param  string  $content  The HTML content to process
     * @return string The processed content with minified conditionals
     */
    public static function minify(string $content): string
    {
        // Find conditional comment blocks: <!--[if ...]>content<![endif]-->
        return preg_replace_callback(
            '/(<!--\[if\s[^\]]+]>)([\s\S]*?)(<!\[endif]-->)/m',
            function ($matches) {
                $prefix = $matches[1];  // <!--[if ...]>
                $innerContent = $matches[2];  // Content between conditionals
                $suffix = $matches[3];  // <![endif]-->

                // Remove spaces between tags: > spaces < becomes ><
                $processedContent = preg_replace(
                    '/(^|>)(\s+)(<|$)/m',
                    '$1$3',
                    $innerContent
                );

                // Replace multiple spaces with single space
                $processedContent = preg_replace('/\s{2,}/m', ' ', $processedContent);

                return $prefix.$processedContent.$suffix;
            },
            $content
        );
    }

    /**
     * Merge adjacent Outlook conditional comments
     *
     * Removes unnecessary closing and opening tags when the same conditional
     * appears consecutively: <![endif]--><!--[if mso | IE]> becomes nothing
     *
     * @param  string  $content  The HTML content to process
     * @return string The processed content with merged conditionals
     */
    public static function merge(string $content): string
    {
        // Remove adjacent endif/if pairs for mso | IE conditionals
        return preg_replace(
            '/(<!\[endif]-->\s*?<!--\[if mso \| IE]>)/m',
            '',
            $content
        );
    }

    /**
     * Process content with both minification and merging
     *
     * @param  string  $content  The HTML content to process
     * @return string The fully processed content
     */
    public static function process(string $content): string
    {
        $content = self::minify($content);
        $content = self::merge($content);

        return $content;
    }

    /**
     * Enhanced merge that handles any matching conditionals, not just mso | IE
     *
     * @param  string  $content  The HTML content to process
     * @return string The processed content with merged conditionals
     */
    public static function mergeEnhanced(string $content): string
    {
        // First do the basic mso | IE merge
        $content = self::merge($content);

        // Then handle other matching conditionals
        return preg_replace_callback(
            '/(<!\[endif]-->)\s*?(<!--\[if\s([^\]]+)]>)/m',
            function ($matches) {
                // Check if the previous conditional matches the next one
                if (preg_match('/<!--\[if\s'.preg_quote($matches[3], '/').']>/', $matches[0])) {
                    return ''; // Remove the endif/if pair
                }

                return $matches[0]; // Keep as is if they don't match
            },
            $content
        );
    }

    /**
     * Check if content contains Outlook conditionals
     *
     * @param  string  $content  The HTML content to check
     * @return bool True if conditionals are found
     */
    public static function hasConditionals(string $content): bool
    {
        return preg_match('/<!--\[if\s[^\]]+]>/', $content) === 1;
    }

    /**
     * Extract all conditional blocks from content
     *
     * @param  string  $content  The HTML content to analyze
     * @return array Array of conditional blocks with their conditions and content
     */
    public static function extractConditionals(string $content): array
    {
        $conditionals = [];

        preg_match_all(
            '/(<!--\[if\s([^\]]+)]>)([\s\S]*?)(<!\[endif]-->)/m',
            $content,
            $matches,
            PREG_SET_ORDER
        );

        foreach ($matches as $match) {
            $conditionals[] = [
                'full' => $match[0],
                'condition' => $match[2],
                'content' => $match[3],
                'start_tag' => $match[1],
                'end_tag' => $match[4],
            ];
        }

        return $conditionals;
    }

    /**
     * Remove all Outlook conditionals from content
     *
     * @param  string  $content  The HTML content to process
     * @param  bool  $keepContent  Whether to keep the content inside conditionals
     * @return string The processed content
     */
    public static function removeConditionals(string $content, bool $keepContent = false): string
    {
        if ($keepContent) {
            // Keep the content but remove the conditional tags
            return preg_replace(
                '/(<!--\[if\s[^\]]+]>)([\s\S]*?)(<!\[endif]-->)/m',
                '$2',
                $content
            );
        }

        // Remove everything including the content
        return preg_replace(
            '/<!--\[if\s[^\]]+]>[\s\S]*?<!\[endif]-->/m',
            '',
            $content
        );
    }
}
