<?php

namespace colq2\BladeMjml\Helpers;

class ConditionalTag
{
    // Constant strings for the different conditional tags
    public const START_CONDITIONAL_TAG = '<!--[if mso | IE]>';

    public const START_MSO_CONDITIONAL_TAG = '<!--[if mso]>';

    public const END_CONDITIONAL_TAG = '<![endif]-->';

    public const START_NEGATION_CONDITIONAL_TAG = '<!--[if !mso | IE]><!-->';

    public const START_MSO_NEGATION_CONDITIONAL_TAG = '<!--[if !mso]><!-->';

    public const END_NEGATION_CONDITIONAL_TAG = '<!--<![endif]-->';

    /**
     * Creates a conditional tag for Microsoft Outlook and Internet Explorer.
     *
     * @param  string  $content  The content to be conditionally rendered
     * @param  bool  $negation  Whether the condition should be negated
     * @return string The conditional tag string
     */
    public static function conditionalTag(string $content, bool $negation = false): string
    {
        return '
    '.($negation ? self::START_NEGATION_CONDITIONAL_TAG : self::START_CONDITIONAL_TAG)."
    {$content}
    ".($negation ? self::END_NEGATION_CONDITIONAL_TAG : self::END_CONDITIONAL_TAG).'
  ';
    }

    /**
     * Creates a conditional tag only for Microsoft Outlook.
     *
     * @param  string  $content  The content to be conditionally rendered
     * @param  bool  $negation  Whether the condition should be negated
     * @return string The conditional tag string
     */
    public static function msoConditionalTag(string $content, bool $negation = false): string
    {
        return '
    '.($negation ? self::START_MSO_NEGATION_CONDITIONAL_TAG : self::START_MSO_CONDITIONAL_TAG)."
    {$content}
    ".($negation ? self::END_NEGATION_CONDITIONAL_TAG : self::END_CONDITIONAL_TAG).'
  ';
    }
}
