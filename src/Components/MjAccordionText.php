<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjAccordionText extends MjmlBodyComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $backgroundColor = '',
        public string $fontSize = '13px',
        public string $fontFamily = '',
        public string $fontWeight = '',
        public string $letterSpacing = '',
        public string $lineHeight = '1',
        public string $color = '',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '16px',
        public string $border = '',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-accordion-text';
    }

    public function allowedAttributes(): array
    {
        return [
            'background-color' => 'color',
            'font-size' => 'unit(px)',
            'font-family' => 'string',
            'font-weight' => 'string',
            'letter-spacing' => 'unitWithNegative(px,em)',
            'line-height' => 'unit(px,%,)',
            'color' => 'color',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'border' => 'string',
        ];
    }

    public function getStyles(): array
    {
        return [
            'td' => [
                'background' => $this->getAttribute('background-color'),
                'font-size' => $this->getAttribute('font-size'),
                'font-family' => $this->getAttribute('font-family'),
                'font-weight' => $this->getAttribute('font-weight'),
                'letter-spacing' => $this->getAttribute('letter-spacing'),
                'line-height' => $this->getAttribute('line-height'),
                'color' => $this->getAttribute('color'),
                'padding-bottom' => $this->getAttribute('padding-bottom'),
                'padding-left' => $this->getAttribute('padding-left'),
                'padding-right' => $this->getAttribute('padding-right'),
                'padding-top' => $this->getAttribute('padding-top'),
                'padding' => $this->getAttribute('padding'),
            ],
            'table' => [
                'width' => '100%',
                'border-bottom' => $this->getAttribute('border'),
            ],
        ];
    }

    public function renderMjml(array $data): View|string
    {
        return '
      <div
        '.$this->htmlAttributes([
            'class' => 'mj-accordion-content',
        ]).'
      >
        <table
          '.$this->htmlAttributes([
            'cellspacing' => '0',
            'cellpadding' => '0',
            'style' => 'table',
        ]).'
        >
          <tbody>
            <tr>
              <td
                '.$this->htmlAttributes([
            'class' => $this->getAttribute('css-class'),
            'style' => 'td',
        ]).'
              >
                {{ $slot }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    ';
    }
}
