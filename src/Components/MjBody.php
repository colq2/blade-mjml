<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjBody extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $mjClass = null,
        public string $backgroundColor = '',
        public string $cssClass = '',
        public string $width = '600px',
    ) {
        parent::__construct($bladeMjmlContext, $mjClass);

        $this->bladeMjmlContext->setBackgroundColor($this->backgroundColor);
        $this->bladeMjmlContext->setContainerWidth($this->width);
    }

    public function getComponentName(): string
    {
        return 'mj-body';
    }

    public function allowedAttributes(): array
    {
        return [
            'width' => 'unit(px)',
            'background-color' => 'color',
        ];
    }

    public function getStyles(): array
    {
        return [
            'body' => [
                'background-color' => $this->getAttribute('background-color'),
            ],
        ];
    }

    public function renderMjml(array $data): View|string
    {
        $class = $data['attributes']->merge([
            'class' => $this->getAttribute('css-class'),
        ])['class'] ?? '';

        return '
      <div
        '.$this->htmlAttributes([
            'class' => $class,
            'style' => 'body',
            'lang' => $this->bladeMjmlContext->lang,
            'dir' => $this->bladeMjmlContext->dir,
        ]).'
      >{{ $slot }}</div>';
    }
}
