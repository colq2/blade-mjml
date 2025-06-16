<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\Helpers\HtmlAttributesHelper;
use Illuminate\View\Component;

abstract class MjmlComponent extends Component implements \colq2\BladeMjml\Contracts\MjmlComponent
{
    abstract public function getComponentName(): string;

    abstract public function getStyles(): array;

    /**
     * Format CSS styles.
     *
     * @param  array|string|null  $styles  The styles to format.
     * @return string The formatted CSS styles string.
     */
    public function styles($styles): string
    {
        $stylesObject = null;

        if ($styles) {
            if (is_string($styles)) {
                $stylesObject = HtmlAttributesHelper::get($this->getStyles(), $styles);
            } else {
                $stylesObject = $styles;
            }
        }

        if (! is_array($stylesObject)) {
            return '';
        }

        $output = '';
        foreach ($stylesObject as $name => $value) {
            if (! HtmlAttributesHelper::isNil($value)) {
                $output .= "{$name}:{$value};";
            }
        }

        return $output;
    }

    /**
     * Generate HTML attributes string.
     *
     * @param  array  $attributes  The attributes to format.
     * @return string The formatted HTML attributes string.
     */
    public function htmlAttributes(array $attributes, array $allowedNilAttributes = []): string
    {
        $specialAttributes = [
            'style' => function ($v) {
                return $this->styles($v);
            },
            'default' => [HtmlAttributesHelper::class, 'identity'],
        ];

        $filteredAttributes = HtmlAttributesHelper::omitNil($attributes, $allowedNilAttributes);
        $output = '';

        foreach ($filteredAttributes as $name => $v) {
            $handler = $specialAttributes[$name] ?? $specialAttributes['default'];
            $value = call_user_func($handler, $v);

            $output .= " {$name}=\"{$value}\"";
        }

        return $output;
    }
}
