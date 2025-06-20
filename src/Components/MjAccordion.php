<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjAccordion extends MjmlBodyComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $containerBackgroundColor = '',
        public string $border = '2px solid black',
        public string $fontFamily = 'Ubuntu, Helvetica, Arial, sans-serif',
        public string $iconAlign = 'middle',
        public string $iconWidth = '32px',
        public string $iconHeight = '32px',
        public string $iconWrappedUrl = 'https://i.imgur.com/bIXv1bk.png',
        public string $iconWrappedAlt = '+',
        public string $iconUnwrappedUrl = 'https://i.imgur.com/w4uTygT.png',
        public string $iconUnwrappedAlt = '-',
        public string $iconPosition = 'right',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '10px 25px',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-accordion';
    }

    public function allowedAttributes(): array
    {
        return [
            'container-background-color' => 'color',
            'border' => 'string',
            'font-family' => 'string',
            'icon-align' => 'enum(top,middle,bottom)',
            'icon-width' => 'unit(px,%)',
            'icon-height' => 'unit(px,%)',
            'icon-wrapped-url' => 'string',
            'icon-wrapped-alt' => 'string',
            'icon-unwrapped-url' => 'string',
            'icon-unwrapped-alt' => 'string',
            'icon-position' => 'enum(left,right)',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
        ];
    }

    public function headStyle(): ?\Closure
    {
        return function () {
            return <<<'CSS'
noinput.mj-accordion-checkbox { display:block!important; }

@media yahoo, only screen and (min-width:0) {
  .mj-accordion-element { display:block; }
  input.mj-accordion-checkbox, .mj-accordion-less { display:none!important; }
  input.mj-accordion-checkbox + * .mj-accordion-title { cursor:pointer; touch-action:manipulation; -webkit-user-select:none; -moz-user-select:none; user-select:none; }
  input.mj-accordion-checkbox + * .mj-accordion-content { overflow:hidden; display:none; }
  input.mj-accordion-checkbox + * .mj-accordion-more { display:block!important; }
  input.mj-accordion-checkbox:checked + * .mj-accordion-content { display:block; }
  input.mj-accordion-checkbox:checked + * .mj-accordion-more { display:none!important; }
  input.mj-accordion-checkbox:checked + * .mj-accordion-less { display:block!important; }
}

.moz-text-html input.mj-accordion-checkbox + * .mj-accordion-title { cursor: auto; touch-action: auto; -webkit-user-select: auto; -moz-user-select: auto; user-select: auto; }
.moz-text-html input.mj-accordion-checkbox + * .mj-accordion-content { overflow: hidden; display: block; }
.moz-text-html input.mj-accordion-checkbox + * .mj-accordion-ico { display: none; }

@goodbye { @gmail }
CSS;
        };
    }

    public function getStyles(): array
    {
        return [
            'table' => [
                'width' => '100%',
                'border-collapse' => 'collapse',
                'border' => $this->getAttribute('border'),
                'border-bottom' => 'none',
                'font-family' => $this->getAttribute('font-family'),
            ],
        ];
    }

    public function getChildContext(): array
    {
        return array_merge($this->context(), [
            'wrapperFn' => null,
            'attributes' => [
                'border' => $this->getAttribute('border'),
                'icon-align' => $this->getAttribute('icon-align'),
                'icon-width' => $this->getAttribute('icon-width'),
                'icon-height' => $this->getAttribute('icon-height'),
                'icon-position' => $this->getAttribute('icon-position'),
                'icon-wrapped-url' => $this->getAttribute('icon-wrapped-url'),
                'icon-wrapped-alt' => $this->getAttribute('icon-wrapped-alt'),
                'icon-unwrapped-url' => $this->getAttribute('icon-unwrapped-url'),
                'icon-unwrapped-alt' => $this->getAttribute('icon-unwrapped-alt'),
            ],
        ]);
    }

    public function renderMjml(array $data): View|string
    {
        return '
      <table
        '.$this->htmlAttributes([
            'cellspacing' => '0',
            'cellpadding' => '0',
            'class' => 'mj-accordion',
            'style' => 'table',
        ]).'
      >
        <tbody>
          {{ $slot }}
        </tbody>
      </table>
    ';
    }
}
