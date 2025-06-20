<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\ConditionalTag;
use colq2\BladeMjml\Helpers\SuffixCssClasses;
use Illuminate\Contracts\View\View;

class MjNavbarLink extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $color = '#000000',
        public string $fontFamily = 'Ubuntu, Helvetica, Arial, sans-serif',
        public string $fontSize = '13px',
        public string $fontStyle = '',
        public string $fontWeight = 'normal',
        public string $href = '',
        public string $name = '',
        public string $target = '_blank',
        public string $rel = '',
        public string $letterSpacing = '',
        public string $lineHeight = '22px',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '15px 10px',
        public string $textDecoration = 'none',
        public string $textTransform = 'uppercase',
        public string $cssClass = '',
        public string $navbarBaseUrl = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-navbar-link';
    }

    public function allowedAttributes(): array
    {
        return [
            'color' => 'color',
            'font-family' => 'string',
            'font-size' => 'unit(px)',
            'font-style' => 'string',
            'font-weight' => 'string',
            'href' => 'string',
            'name' => 'string',
            'target' => 'string',
            'rel' => 'string',
            'letter-spacing' => 'unitWithNegative(px,em)',
            'line-height' => 'unit(px,%,)',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'text-decoration' => 'string',
            'text-transform' => 'string',
            'navbar-base-url' => 'string',
        ];
    }

    public function getStyles(): array
    {
        return [
            'a' => [
                'display' => 'inline-block',
                'color' => $this->getAttribute('color'),
                'font-family' => $this->getAttribute('font-family'),
                'font-size' => $this->getAttribute('font-size'),
                'font-style' => $this->getAttribute('font-style'),
                'font-weight' => $this->getAttribute('font-weight'),
                'letter-spacing' => $this->getAttribute('letter-spacing'),
                'line-height' => $this->getAttribute('line-height'),
                'text-decoration' => $this->getAttribute('text-decoration'),
                'text-transform' => $this->getAttribute('text-transform'),
                'padding' => $this->getAttribute('padding'),
                'padding-top' => $this->getAttribute('padding-top'),
                'padding-left' => $this->getAttribute('padding-left'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
            ],
            'td' => [
                'padding' => $this->getAttribute('padding'),
                'padding-top' => $this->getAttribute('padding-top'),
                'padding-left' => $this->getAttribute('padding-left'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
            ],
        ];
    }

    public function renderMjml(array $data): View|string
    {
        $href = $this->getAttribute('href');
        $navbarBaseUrl = $this->getAttribute('navbar-base-url');
        $link = $navbarBaseUrl ? $navbarBaseUrl.$href : $href;

        $cssClass = $this->getAttribute('css-class');
        $class = 'mj-link'.($cssClass ? ' '.$cssClass : '');

        $conditionalTd = ConditionalTag::conditionalTag('
            <td '.$this->htmlAttributes([
            'style' => 'td',
            'class' => SuffixCssClasses::suffixCssClasses($this->getAttribute('css-class') ?: '', 'outlook'),
        ]).'>
        ');

        $conditionalTdEnd = ConditionalTag::conditionalTag('</td>');

        return '
        '.$conditionalTd.'
            <a '.$this->htmlAttributes([
            'class' => $class,
            'href' => $link,
            'rel' => $this->getAttribute('rel'),
            'target' => $this->getAttribute('target'),
            'name' => $this->getAttribute('name'),
            'style' => 'a',
        ]).'>
                {{ $slot }}
            </a>
        '.$conditionalTdEnd.'
        ';
    }
}
