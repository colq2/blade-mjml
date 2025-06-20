<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use colq2\BladeMjml\Helpers\ConditionalTag;
use Illuminate\Contracts\View\View;

class MjAccordionElement extends MjmlBodyComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $backgroundColor = '',
        public string $border = '',
        public string $fontFamily = '',
        public string $iconAlign = '',
        public string $iconWidth = '',
        public string $iconHeight = '',
        public string $iconWrappedUrl = '',
        public string $iconWrappedAlt = '',
        public string $iconUnwrappedUrl = '',
        public string $iconUnwrappedAlt = '',
        public string $iconPosition = '',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-accordion-element';
    }

    public function allowedAttributes(): array
    {
        return [
            'background-color' => 'color',
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
        ];
    }

    public function getStyles(): array
    {
        return [
            'td' => [
                'padding' => '0px',
                'background-color' => $this->getAttribute('background-color'),
            ],
            'label' => [
                'font-size' => '13px',
                'font-family' => $this->getAttribute('font-family'),
            ],
            'input' => [
                'display' => 'none',
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
        $conditionalInput = ConditionalTag::conditionalTag('
            <input
              '.$this->htmlAttributes([
            'class' => 'mj-accordion-checkbox',
            'type' => 'checkbox',
            'style' => 'input',
        ]).'
            />
        ', true);

        return '
      <tr
        '.$this->htmlAttributes([
            'class' => $this->getAttribute('css-class'),
        ]).'
      >
        <td '.$this->htmlAttributes(['style' => 'td']).'>
          <label
            '.$this->htmlAttributes([
            'class' => 'mj-accordion-element',
            'style' => 'label',
        ]).'
          >
            '.$conditionalInput.'
            <div>
              {{ $slot }}
            </div>
          </label>
        </td>
      </tr>
    ';
    }
}
