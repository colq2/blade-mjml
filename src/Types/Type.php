<?php

namespace colq2\BladeMjml\Types;

abstract class Type
{
    protected $value;

    protected array $matchers = [];

    public static string $typeChecker;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isValid(): bool
    {
        foreach ($this->matchers as $matcher) {
            if (preg_match($matcher, (string) $this->value)) {
                return true;
            }
        }

        return false;
    }

    public function getErrorMessage(): ?string
    {
        if ($this->isValid()) {
            return null;
        }

        $errorMessage = $this->errorMessage ?? "has invalid value: {$this->value} for type ".get_class($this);

        return str_replace('$value', $this->value, $errorMessage);
    }

    public function getValue()
    {
        return $this->value;
    }

    public static function check(string $type): bool
    {
        return (bool) preg_match(static::$typeChecker, $type);
    }
}
