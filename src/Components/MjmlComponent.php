<?php

namespace colq2\BladeMjml\Components;

use Illuminate\View\Component;

abstract class MjmlComponent extends Component implements \colq2\BladeMjml\Contracts\MjmlComponent
{
    abstract public function getComponentName(): string;
}
