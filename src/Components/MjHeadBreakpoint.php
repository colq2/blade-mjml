<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjHeadBreakpoint extends MjmlHeadComponent
{

    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public string $width = '',

    )
    {
        parent::__construct($bladeMjmlContext);
    }


    public function getComponentName(): string
    {
        return 'mj-breakpoint';
    }

    public function allowedAttributes(): array
    {
        return [
            'width' => 'unit(px)',
        ];
    }

    public function renderMjml(array $data): View|string
    {
        $this->bladeMjmlContext->breakpoint = $this->getAttribute('width');

        return '';
    }
}
