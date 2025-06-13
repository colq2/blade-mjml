<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjHeadStyle extends MjmlHeadComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public string $inline = '',
    ) {
        parent::__construct($bladeMjmlContext);
    }

    public function getComponentName(): string
    {
        return 'mj-style';
    }

    public function allowedAttributes(): array
    {
        return [
            'inline' => 'string',
        ];
    }

    public function renderMjml(array $data): View|string
    {
        if ($this->getAttribute('inline') === 'inline') {
            $this->bladeMjmlContext->inlineStyle[] = $data['slot'];
        } else {
            $this->bladeMjmlContext->style[] = $data['slot'];
        }

        return '';
    }
}
