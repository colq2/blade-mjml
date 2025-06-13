<?php

namespace colq2\BladeMjml\Components;

use colq2\BladeMjml\BladeMjmlGlobalContext;
use Illuminate\Contracts\View\View;

class MjRaw extends MjmlBodyComponent
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public BladeMjmlGlobalContext $bladeMjmlContext,
        public ?string $position = null,
    ) {
        parent::__construct($bladeMjmlContext);
    }

    public function getComponentName(): string
    {
        return 'mj-raw';
    }

    public function allowedAttributes(): array
    {
        return [
            'position' => 'enum(file-start)',
        ];
    }

    public function renderMjml(array $data): View|string
    {
        return '{{ $slot }}';
    }
}
