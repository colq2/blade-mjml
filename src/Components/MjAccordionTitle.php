<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjAccordionTitle extends MjmlBodyComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $backgroundColor = '',
        public string $color = '',
        public string $fontSize = '13px',
        public string $fontFamily = '',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '16px',
        public string $iconAlign = '',
        public string $iconWidth = '',
        public string $iconHeight = '',
        public string $iconWrappedUrl = '',
        public string $iconWrappedAlt = '',
        public string $iconUnwrappedUrl = '',
        public string $iconUnwrappedAlt = '',
        public string $iconPosition = '',
        public string $border = '',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-accordion-title';
    }

    public function allowedAttributes(): array
    {
        return [
            'background-color' => 'color',
            'color' => 'color',
            'font-size' => 'unit(px)',
            'font-family' => 'string',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
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
                'width' => '100%',
                'background-color' => $this->getAttribute('background-color'),
                'color' => $this->getAttribute('color'),
                'font-size' => $this->getAttribute('font-size'),
                'font-family' => $this->getAttribute('font-family'),
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
            'td2' => [
                'padding' => '16px',
                'background' => $this->getAttribute('background-color'),
                'vertical-align' => $this->getAttribute('icon-align'),
            ],
            'img' => [
                'display' => 'none',
                'width' => $this->getAttribute('icon-width'),
                'height' => $this->getAttribute('icon-height'),
            ],
        ];
    }

    public function renderMjml(array $data): View|string
    {
        $iconPosition = $this->getAttribute('icon-position') ?: 'right';
        $icons = '
      <td
        '.$this->htmlAttributes([
            'class' => 'mj-accordion-ico',
            'style' => 'td2',
        ]).'
      >
        <img
          '.$this->htmlAttributes([
            'src' => $this->getAttribute('icon-wrapped-url'),
            'alt' => $this->getAttribute('icon-wrapped-alt'),
            'class' => 'mj-accordion-more',
            'style' => 'img',
        ]).'
        />
        <img
          '.$this->htmlAttributes([
            'src' => $this->getAttribute('icon-unwrapped-url'),
            'alt' => $this->getAttribute('icon-unwrapped-alt'),
            'class' => 'mj-accordion-less',
            'style' => 'img',
        ]).'
        />
      </td>
    ';
        $title = '
      <td
        '.$this->htmlAttributes([
            'class' => $this->getAttribute('css-class'),
            'style' => 'td',
        ]).'
      >
        {{ $slot }}
      </td>
    ';
        $content = $iconPosition === 'right'
            ? $title.$icons
            : $icons.$title;

        return '
      <div '.$this->htmlAttributes(['class' => 'mj-accordion-title']).'>
        <table
          '.$this->htmlAttributes([
            'cellspacing' => '0',
            'cellpadding' => '0',
            'style' => 'table',
        ]).'
        >
          <tbody>
            <tr>
              '.$content.'
            </tr>
          </tbody>
        </table>
      </div>
    ';
    }
}
