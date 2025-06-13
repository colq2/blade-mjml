<?php

namespace colq2\BladeMjml\Types;

class ColorType extends Type
{
    public static string $typeChecker = '/^color/i';

    public function __construct($value)
    {
        parent::__construct($value);

        $colorNames = require __DIR__ . '/../Helpers/colors.php';
        $colorsList = implode('|', $colorNames);

        $this->matchers = [
            '/rgba\(\d{1,3},\s?\d{1,3},\s?\d{1,3},\s?\d(\.\d{1,3})?\)/i',
            '/rgb\(\d{1,3},\s?\d{1,3},\s?\d{1,3}\)/i',
            '/^#([0-9a-f]{3}){1,2}$/i',
            "/^({$colorsList})$/",
        ];
    }

    public function getValue()
    {
        // Konvertierung von Shorthand-Hex (#abc) zu vollständigem Hex (#aabbcc)
        if (is_string($this->value) && preg_match('/^#\w{3}$/', $this->value)) {
            return preg_replace_callback('/^#(\w)(\w)(\w)$/', function($matches) {
                return "#{$matches[1]}{$matches[1]}{$matches[2]}{$matches[2]}{$matches[3]}{$matches[3]}";
            }, $this->value);
        }

        return $this->value;
    }
}
