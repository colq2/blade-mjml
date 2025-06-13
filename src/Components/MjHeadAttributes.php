<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;
use Illuminate\View\Compilers\BladeCompiler;

class MjHeadAttributes extends MjmlHeadComponent
{

    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
    )
    {
        parent::__construct($bladeMjmlContext);
    }


    public function getComponentName(): string
    {
        return 'mj-attributes';
    }

    public function allowedAttributes(): array
    {
        return [];
    }

    public function renderMjml(array $data): View|string
    {
        // TODO: We need to get inner html and add it to the mj-attributes tag
        // parse that into nodes, extract the attributes and add them to the global context
        return '';
    }
}
