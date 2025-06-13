<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjHead extends MjmlHeadComponent
{
    public function __construct(BladeMjmlGlobalContext $bladeMjmlContext)
    {
        parent::__construct($bladeMjmlContext);
    }

    public function getComponentName(): string
    {
        return 'mj-head';
    }

    public function allowedAttributes(): array
    {
        return [];
    }

    public function renderMjml(array $data): View|string
    {
        return '{{ $slot }}';
    }
}
