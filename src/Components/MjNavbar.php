<?php

namespace colq2\BladeMjml\Components;

use Closure;
use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\ConditionalTag;
use colq2\BladeMjml\Helpers\MakeLowerBreakpoint;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class MjNavbar extends MjmlBodyComponent
{
    public string $labelKey;

    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $align = 'center',
        public ?string $baseUrl = null,
        public ?string $hamburger = null,
        public string $icoAlign = 'center',
        public string $icoOpen = '&#9776;',
        public string $icoClose = '&#8855;',
        public string $icoColor = '#000000',
        public string $icoFontSize = '30px',
        public string $icoFontFamily = 'Ubuntu, Helvetica, Arial, sans-serif',
        public string $icoTextTransform = 'uppercase',
        public string $icoPadding = '10px',
        public string $icoPaddingLeft = '',
        public string $icoPaddingTop = '',
        public string $icoPaddingRight = '',
        public string $icoPaddingBottom = '',
        public string $icoTextDecoration = 'none',
        public string $icoLineHeight = '30px',
        public string $padding = '',
        public string $paddingLeft = '',
        public string $paddingTop = '',
        public string $paddingRight = '',
        public string $paddingBottom = '',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
        $this->labelKey = 'mj-navbar-'.Str::random(8);
    }

    public function getComponentName(): string
    {
        return 'mj-navbar';
    }

    public function allowedAttributes(): array
    {
        return [
            'align' => 'enum(left,center,right)',
            'base-url' => 'string',
            'hamburger' => 'string',
            'ico-align' => 'enum(left,center,right)',
            'ico-open' => 'string',
            'ico-close' => 'string',
            'ico-color' => 'color',
            'ico-font-size' => 'unit(px,%)',
            'ico-font-family' => 'string',
            'ico-text-transform' => 'string',
            'ico-padding' => 'unit(px,%){1,4}',
            'ico-padding-left' => 'unit(px,%)',
            'ico-padding-top' => 'unit(px,%)',
            'ico-padding-right' => 'unit(px,%)',
            'ico-padding-bottom' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'padding-left' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-bottom' => 'unit(px,%)',
            'ico-text-decoration' => 'string',
            'ico-line-height' => 'unit(px,%,)',
        ];
    }

    public function headStyle(): ?Closure
    {
        return function ($breakpoint) {
            $maxWidth = MakeLowerBreakpoint::makeLowerBreakpoint($breakpoint);

            return "
                noinput.mj-menu-checkbox { display:block!important; max-height:none!important; visibility:visible!important; }

                @media only screen and (max-width:{$maxWidth}) {
                  .mj-menu-checkbox[type=\"checkbox\"] ~ .mj-inline-links { display:none!important; }
                  .mj-menu-checkbox[type=\"checkbox\"]:checked ~ .mj-inline-links,
                  .mj-menu-checkbox[type=\"checkbox\"] ~ .mj-menu-trigger { display:block!important; max-width:none!important; max-height:none!important; font-size:inherit!important; }
                  .mj-menu-checkbox[type=\"checkbox\"] ~ .mj-inline-links > a { display:block!important; }
                  .mj-menu-checkbox[type=\"checkbox\"]:checked ~ .mj-menu-trigger .mj-menu-icon-close { display:block!important; }
                  .mj-menu-checkbox[type=\"checkbox\"]:checked ~ .mj-menu-trigger .mj-menu-icon-open { display:none!important; }
                }
            ";
        };
    }

    public function getChildContext(): array
    {
        return array_merge($this->context(), [
            'wrapperFn' => null,
            'attributes' => [
                'navbar-base-url' => $this->getAttribute('base-url'),
            ],
        ]);
    }

    public function getStyles(): array
    {
        return [
            'div' => [
                'align' => $this->getAttribute('align'),
                'width' => '100%',
            ],
            'label' => [
                'display' => 'block',
                'cursor' => 'pointer',
                'mso-hide' => 'all',
                '-moz-user-select' => 'none',
                'user-select' => 'none',
                'color' => $this->getAttribute('ico-color'),
                'font-size' => $this->getAttribute('ico-font-size'),
                'font-family' => $this->getAttribute('ico-font-family'),
                'text-transform' => $this->getAttribute('ico-text-transform'),
                'text-decoration' => $this->getAttribute('ico-text-decoration'),
                'line-height' => $this->getAttribute('ico-line-height'),
                'padding-top' => $this->getAttribute('ico-padding-top'),
                'padding-right' => $this->getAttribute('ico-padding-right'),
                'padding-bottom' => $this->getAttribute('ico-padding-bottom'),
                'padding-left' => $this->getAttribute('ico-padding-left'),
                'padding' => $this->getAttribute('ico-padding'),
            ],
            'trigger' => [
                'display' => 'none',
                'max-height' => '0px',
                'max-width' => '0px',
                'font-size' => '0px',
                'overflow' => 'hidden',
            ],
            'icoOpen' => [
                'mso-hide' => 'all',
            ],
            'icoClose' => [
                'display' => 'none',
                'mso-hide' => 'all',
            ],
        ];
    }

    protected function renderHamburger(): string
    {
        $labelKey = $this->labelKey;
        $conditionalInput = ConditionalTag::msoConditionalTag(
            '<input type="checkbox" id="'.$labelKey.'" class="mj-menu-checkbox" style="display:none !important; max-height:0; visibility:hidden;" />',
            true
        );

        return '
        '.$conditionalInput.'
        <div '.$this->htmlAttributes([
            'class' => 'mj-menu-trigger',
            'style' => 'trigger',
        ]).'>
            <label '.$this->htmlAttributes([
            'for' => $labelKey,
            'class' => 'mj-menu-label',
            'style' => 'label',
            'align' => $this->getAttribute('ico-align'),
        ]).'>
                <span '.$this->htmlAttributes([
            'class' => 'mj-menu-icon-open',
            'style' => 'icoOpen',
        ]).'>'.
            $this->getAttribute('ico-open').'
                </span>
                <span '.$this->htmlAttributes([
                'class' => 'mj-menu-icon-close',
                'style' => 'icoClose',
            ]).'>'.
            $this->getAttribute('ico-close').'
                </span>
            </label>
        </div>
        ';
    }

    public function renderMjml(array $data): View|string
    {
        $hamburger = $this->getAttribute('hamburger') === 'hamburger' ? $this->renderHamburger() : '';
        $baseUrl = $this->getAttribute('base-url');
        $align = $this->getAttribute('align');
        $cssClass = $this->getAttribute('css-class');

        $conditionalTableStart = ConditionalTag::conditionalTag(
            '<table role="presentation" border="0" cellpadding="0" cellspacing="0" align="'.$align.'"><tr>'
        );
        $conditionalTableEnd = ConditionalTag::conditionalTag(
            '</tr></table>'
        );

        return '
        '.$hamburger.'
        <div '.$this->htmlAttributes([
            'class' => 'mj-inline-links'.($cssClass ? ' '.$cssClass : ''),
            'style' => '',
        ], ['style']).'>
            '.$conditionalTableStart.'
                {{ $slot }}
            '.$conditionalTableEnd.'
        </div>
        ';
    }
}
