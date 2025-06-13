<?php

namespace colq2\BladeMjml\Types;

class EnumType extends Type
{
    public static string $typeChecker = '/^enum/i';
    protected string $errorMessage = 'has invalid value: $value for type Enum, only accepts $validValues';
    protected array $validValues = [];

    public function __construct($value, string $typeConfig)
    {
        parent::__construct($value);

        // Extrahieren der Werte aus dem Format enum(val1,val2,val3)
        if (preg_match('/\(([^)]+)\)/', $typeConfig, $matches)) {
            $this->validValues = explode(',', $matches[1]);

            // Erstellen der regulären Ausdrücke für jeden gültigen Wert
            $this->matchers = array_map(function($value) {
                return '/^' . preg_quote($value, '/') . '$/';
            }, $this->validValues);
        }
    }

    public function getErrorMessage(): ?string
    {
        if ($this->isValid()) {
            return null;
        }

        $message = str_replace('$value', $this->value, $this->errorMessage);
        return str_replace('$validValues', implode(', ', $this->validValues), $message);
    }
}
