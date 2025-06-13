<?php

namespace colq2\BladeMjml\Types;

/**
 * Verwaltet die Typkonstruktoren und stellt die initializeType-Funktion bereit,
 * ähnlich wie in der JavaScript-Implementation.
 */
class TypeRegistry
{
    protected static array $types = [];

    protected static array $typeConstructors = [
        BooleanType::class,
        ColorType::class,
        EnumType::class,
        UnitType::class,
        StringType::class,
        IntegerType::class,
    ];

    /**
     * Initialisiert einen Typ basierend auf der Typkonfiguration
     */
    public static function initializeType(string $typeConfig)
    {
        // Gibt einen bereits initialisierten Typ zurück
        if (isset(static::$types[$typeConfig])) {
            return static::$types[$typeConfig];
        }

        // Findet den passenden TypeConstructor basierend auf dem typeConfig String
        foreach (static::$typeConstructors as $typeClass) {
            if (preg_match($typeClass::$typeChecker, $typeConfig)) {
                // Spezieller Fall für Enum und Unit, die zusätzliche Parameter benötigen
                if ($typeClass === EnumType::class || $typeClass === UnitType::class) {
                    static::$types[$typeConfig] = function ($value) use ($typeClass, $typeConfig) {
                        return new $typeClass($value, $typeConfig);
                    };
                } else {
                    static::$types[$typeConfig] = function ($value) use ($typeClass) {
                        return new $typeClass($value);
                    };
                }

                return static::$types[$typeConfig];
            }
        }

        throw new \Exception("No type found for {$typeConfig}");
    }
}
