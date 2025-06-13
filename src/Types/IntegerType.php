<?php

namespace colq2\BladeMjml\Types;

class IntegerType extends Type
{
    public static string $typeChecker = '/^integer/i';

    public function __construct($value)
    {
        parent::__construct($value);

        $this->matchers = ['/^\d+$/'];
    }
}
