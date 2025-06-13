<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjHeadPreview extends MjmlHeadComponent
{
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext
    ) {
        parent::__construct($bladeMjmlContext);
    }

    public function getComponentName(): string
    {
        return 'mj-preview';
    }

    public function allowedAttributes(): array
    {
        return [];
    }

    public function renderMjml(array $data): View|string
    {
        $this->bladeMjmlContext->preview($data['slot']);

        return '';
    }
}
