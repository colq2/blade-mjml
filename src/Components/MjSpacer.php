<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjSpacer extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $border = '',
        public string $borderBottom = '',
        public string $borderLeft = '',
        public string $borderRight = '',
        public string $borderTop = '',
        public string $containerBackgroundColor = '',
        public string $paddingBottom = '',
        public string $paddingLeft = '',
        public string $paddingRight = '',
        public string $paddingTop = '',
        public string $padding = '',
        public string $height = '20px',
        public string $cssClass = '',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);
    }

    public function getComponentName(): string
    {
        return 'mj-spacer';
    }

    public function allowedAttributes(): array
    {
        return [
            'border' => 'string',
            'border-bottom' => 'string',
            'border-left' => 'string',
            'border-right' => 'string',
            'border-top' => 'string',
            'container-background-color' => 'color',
            'padding-bottom' => 'unit(px,%)',
            'padding-left' => 'unit(px,%)',
            'padding-right' => 'unit(px,%)',
            'padding-top' => 'unit(px,%)',
            'padding' => 'unit(px,%){1,4}',
            'height' => 'unit(px,%)',
        ];
    }

    public function getStyles(): array
    {
        return [
            'div' => [
                'height' => $this->getAttribute('height'),
                'line-height' => $this->getAttribute('height'),
            ],
        ];
    }

    public function renderMjml(array $data): View|string
    {
        return '
      <div
        '.$this->htmlAttributes([
            'class' => $this->getAttribute('css-class'),
            'style' => 'div',
        ]).'
      >&#8202;</div>
      ';
    }
}
