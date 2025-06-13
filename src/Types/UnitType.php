<?php

namespace colq2\BladeMjml\Types;

class UnitType extends Type
{
    public static string $typeChecker = '/^(unit|unitWithNegative)\(.*\)/i';
    protected string $errorMessage = 'has invalid value: $value for type Unit, only accepts ($units) units and $args value(s)';
    protected array $units = [];
    protected array $args = [];

    public function __construct($value, string $typeConfig)
    {
        parent::__construct($value);

        $allowNeg = preg_match('/^unitWithNegative/', $typeConfig) ? '-|' : '';

        // Extrahieren der Einheiten aus dem Format unit(px,em,%) oder unitWithNegative(px,em,%)
        if (preg_match('/\(([^)]+)\)/', $typeConfig, $matches)) {
            $this->units = explode(',', $matches[1]);

            // Überprüfen, ob "auto" in den Einheiten enthalten ist
            $allowAuto = in_array('auto', $this->units) ? '|auto' : '';
            $filteredUnits = array_filter($this->units, function($u) { return $u !== 'auto'; });

            // Extrahieren der Argumente aus dem Format {1} oder {1,2}
            $argsMatch = [];
            if (preg_match('/\{([^}]+)\}/', $typeConfig, $argsMatch)) {
                $this->args = explode(',', $argsMatch[1]);
            } else {
                $this->args = ['1']; // Standardwert, wenn keine Argumente angegeben sind
            }

            // Erstellen der regulären Ausdrücke
            $unitsPattern = implode('|', array_map(function($unit) {
                return preg_quote($unit, '/');
            }, $filteredUnits));

            $pattern = '^((('. $allowNeg . '\d|,|\.){1,}(' . $unitsPattern . ')|0' . $allowAuto . ')( )?){' . implode(',', $this->args) . '}$';
            $this->matchers = [
                '/' . $pattern . '/',
            ];
        }
    }

    public function getErrorMessage(): ?string
    {
        if ($this->isValid()) {
            return null;
        }

        $message = str_replace('$value', $this->value, $this->errorMessage);
        $message = str_replace('$units', implode(', ', $this->units), $message);
        return str_replace('$args', implode(' to ', $this->args), $message);
    }
}
