<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjHeadFont extends MjmlHeadComponent
{

    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public string $name = '',
        public string $href = '',
    )
    {
        parent::__construct($bladeMjmlContext);
    }


    public function getComponentName(): string
    {
        return 'mj-font';
    }

    public function allowedAttributes(): array
    {
        return [
            'name' => 'string',
            'href' => 'string',
        ];
    }

    public function renderMjml(array $data): View|string
    {
        $this->bladeMjmlContext->fonts[$this->getAttribute('name')] = $this->getAttribute('href');

        return '';
    }
}
