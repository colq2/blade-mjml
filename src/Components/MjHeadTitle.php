<?php

namespace colq2\BladeMjml\Components;

use Closure;
use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MjHeadTitle extends MjmlHeadComponent
{

    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext
    )
    {
        parent::__construct($bladeMjmlContext);
    }


    public function getComponentName(): string
    {
        return 'mj-title';
    }

    public function allowedAttributes(): array
    {
        return [];
    }

    public function renderMjml(array $data): View|string
    {
        $this->bladeMjmlContext->title($data['slot']);

        return '';
    }
}
