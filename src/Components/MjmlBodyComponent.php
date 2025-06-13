<?php

namespace colq2\BladeMjml\Components;

use Closure;
use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\FormatAttributes;
use colq2\BladeMjml\Helpers\HtmlAttributesHelper;
use colq2\BladeMjml\Helpers\ShorthandParser;
use colq2\BladeMjml\Helpers\WidthParser;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class MjmlBodyComponent extends MjmlComponent
{
    /** @var array Mjml attributes */
    protected array $_attributes = [];

    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
    ) {
        $this->_attributes = FormatAttributes::formatAttributes(
            attributes: $this->gatherAttributes(),
            allowedAttributes: $this->allowedAttributes()
        );
    }

    abstract public function getComponentName(): string;

    abstract public function allowedAttributes(): array;

    public function isRawElement(): bool
    {
        return false;
    }

    protected function gatherAttributes(): array
    {
        $allowedAttributes = collect($this->allowedAttributes())->mapWithKeys(function ($type, $attrName) {
            // attribute name is kebab-case we need to check for camelCase
            $camelCaseAttrName = Str::camel($attrName);
            if (isset($this->$camelCaseAttrName)) {
                return [
                    $attrName => $this->$camelCaseAttrName,
                ];
            }

            return [];
        })->toArray();

        $additionalAttributes = [];
        if (isset($this->cssClass)) {
            $additionalAttributes['css-class'] = $this->cssClass;
        }

        // TODO: we will also add global attributes
        //        $globalAttributes = $this->bladeMjmlContext->getGlobalAttributes();
        $globalAttributes = [];

        return array_merge(
            $globalAttributes,
            $allowedAttributes,
            $additionalAttributes
        );
    }

    public function getAttribute(string $name)
    {
        $value = Arr::get($this->_attributes, $name);
        if (empty($value)) {
            return null;
        }

        return $value;
    }

    protected function context(): array
    {
        return $this->bladeMjmlContext->read();
    }

    public function wrap(string $content): string
    {
        if($this->isRawElement()){
            return $content;
        }

        $context = $this->context();

        $wrapperFn = Arr::get($context, 'wrapperFn');

        if(!$wrapperFn){
            return $content;
        }

        return $wrapperFn($content, $this);
    }

    public function getChildContext(): array
    {
        return array_merge([$this->bladeMjmlContext->read()]);
    }

    abstract public function renderMjml(array $data): View|string;

    /**
     * This is a wrapper render function to provide context
     * to the child mjml components.
     */
    public function render(): View|Closure|string
    {
        // provide context when rendering
        $this->bladeMjmlContext->push($this->getChildContext());

        return function (array $data) {
            // pop context
            $this->bladeMjmlContext->pop();

            $view = $this->renderMjml($data);

            // wrapping after pop, because else we have the child context.
            return $this->wrap($view);
        };
    }

    /**
     * Get component styles.
     */
    public function getStyles(): array
    {
        return [];
    }

    /**
     * Get shorthand attribute value for a specific direction.
     *
     * @param  string  $attribute  The attribute name.
     * @param  string  $direction  The direction (top, right, bottom, left).
     * @return int The attribute value.
     */
    public function getShorthandAttrValue(string $attribute, string $direction): int
    {
        $mjAttributeDirection = $this->getAttribute("{$attribute}-{$direction}");
        $mjAttribute = $this->getAttribute($attribute);

        if ($mjAttributeDirection !== null) {
            return intval($mjAttributeDirection);
        }

        if ($mjAttribute === null) {
            return 0;
        }

        return ShorthandParser::parse($mjAttribute, $direction);
    }

    /**
     * Get shorthand border value for a specific direction.
     *
     * @param  string|null  $direction  The direction (top, right, bottom, left).
     * @param  string  $attribute  The border attribute name.
     * @return int The border width value.
     */
    public function getShorthandBorderValue(?string $direction, string $attribute = 'border'): int
    {
        $borderDirection = $direction ? $this->getAttribute("{$attribute}-{$direction}") : null;
        $border = $this->getAttribute($attribute);

        return ShorthandParser::parseBorder($borderDirection ?? $border ?? '0');
    }

    /**
     * Get box widths for the component.
     *
     * @return array The box widths.
     */
    public function getBoxWidths(): array
    {
        $context = $this->context();
        $containerWidth = $context['containerWidth'] ?? 600;
        $parsedWidth = intval($containerWidth);

        $paddings =
            $this->getShorthandAttrValue('padding', 'right') +
            $this->getShorthandAttrValue('padding', 'left');

        $borders =
            $this->getShorthandBorderValue('right') +
            $this->getShorthandBorderValue('left');

        return [
            'totalWidth' => $parsedWidth,
            'borders' => $borders,
            'paddings' => $paddings,
            'box' => $parsedWidth - $paddings - $borders,
        ];
    }

    /**
     * Generate HTML attributes string.
     *
     * @param  array  $attributes  The attributes to format.
     * @return string The formatted HTML attributes string.
     */
    public function htmlAttributes(array $attributes): string
    {
        $specialAttributes = [
            'style' => function ($v) {
                return $this->styles($v);
            },
            'default' => [HtmlAttributesHelper::class, 'identity'],
        ];

        $filteredAttributes = HtmlAttributesHelper::omitNil($attributes);
        $output = '';

        foreach ($filteredAttributes as $name => $v) {
            $handler = $specialAttributes[$name] ?? $specialAttributes['default'];
            $value = is_callable($handler) ? call_user_func($handler, $v) : $v;

            $output .= " {$name}=\"{$value}\"";
        }

        return $output;
    }

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
     * In the original mjml implementation this is called in the column component it self, because it renders the children itself.
     * So the column wraps every child in this. We need to call this in the child component itself, because the blade compiler works differently.
     */
    public function innerColumnWrap(string $content): string
    {
        return '
        <tr>
          <td
            '.$this->htmlAttributes([
            'align' => $this->getAttribute('align'),
            'class' => $this->getAttribute('css-class'),
            'style' => [
                'background' => $this->getAttribute('container-background-color'),
                'font-size' => '0px',
                'padding' => $this->getAttribute('padding'),
                'padding-top' => $this->getAttribute('padding-top'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
                'padding-left' => $this->getAttribute('padding-left'),
                'word-break' => 'break-word',
            ],
        ]).'
          >'.$content.'
          </td>
        </tr>
        ';
    }
}
