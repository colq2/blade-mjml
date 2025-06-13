<?php

namespace colq2\BladeMjml\Types;

class BooleanType extends Type
{
    public static string $typeChecker = '/^boolean/i';

    public function __construct($value)
    {
        parent::__construct($value);

        $this->matchers = [
            '/^true$/i',
            '/^false$/i'
        ];
    }

    public function isValid(): bool
    {
        return $this->value === true || $this->value === false;
    }
}
