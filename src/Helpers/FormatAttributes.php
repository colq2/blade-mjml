<?php

namespace colq2\BladeMjml\Helpers;

use colq2\BladeMjml\Types\TypeRegistry;

class FormatAttributes {

    /**
     * Format attributes based on allowed attributes and their types.
     *
     * @param array $attributes The attributes to format.
     * @param array $allowedAttributes The allowed attributes with their types.
     * @return array The formatted attributes.
     */
    public static function formatAttributes(array $attributes, array $allowedAttributes): array
    {
        $result = [];

        foreach ($attributes as $attrName => $value) {
            if (isset($allowedAttributes[$attrName])) {
                try {
                    $typeConstructor = TypeRegistry::initializeType($allowedAttributes[$attrName]);

                    if ($typeConstructor) {
                        $type = $typeConstructor($value);
                        $result[$attrName] = $type->getValue();
                        continue;
                    }
                } catch (\Exception $e) {
                    // ignore exceptions and continue
                }
            }

            // just use the value as is
            $result[$attrName] = $value;
        }

        return $result;
    }
}


