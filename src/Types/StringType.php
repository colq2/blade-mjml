<?php

namespace colq2\BladeMjml\Types;

class StringType extends Type
{
    public static string $typeChecker = '/^string/i';

    public function __construct($value)
    {
        parent::__construct($value);

        $this->matchers = ['/.*/']; // Akzeptiert jeden String
    }
}
