<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Traits;

trait TypeTrait
{
    /**
     * Returns the type of a value
     * @param mixed $value
     * @return string "array", "boolean", "float", "int", "null", "object", "string" or "unknown"
     */
    protected function getType(mixed $value): string
    {
        $type = gettype($value);
        return $this->normalizeTypeName($type);
    }


    /**
     * Returns the type of a property, if is not setted returns "mixed"
     * @param \ReflectionProperty $property
     * @return string "array", "boolean", "float", "int", "mixed", "object", "string" or "unknown"
     */
    protected function getPropertyType(\ReflectionProperty $property): string
    {
        $propType = $property->getType();

        if ($propType === null) {
            return "mixed";
        }

        if (method_exists($propType, "getName")) {
            $type = $propType->getName();
        } else {
            $type = is_string($propType) ? $propType : "unknown";
        }

        return $this->normalizeTypeName($type);
    }


    protected function normalizeTypeName(?string $type): string
    {
        $type = strtolower($type);

        $types = [
            "array",
            "bool",
            "boolean",
            "double",
            "float",
            "int",
            "integer",
            "mixed",
            "null",
            "object",
            "string",
        ];

        if (!in_array($type, $types)) {
            return "unknown";
        }

        // According to PHP documentation of gettype() function:
        // "For historical reasons 'double' is returned in case of a float, and not simply 'float'."
        // But when defining a type you can't use 'double' as a type.
        if ($type == "double") {
            return "float";
        }

        // The PHP gettype() function returns "integer" when the variable type is "int"
        if ($type == "integer") {
            return "int";
        }

        // the \ReflectionProperty->getType returns 'bool' and gettype() returns 'boolean'
        if ($type == "boolean") {
            return "bool";
        }

        return $type;
    }

    /**
     * Checks wheter a value is empty
     * We are not using `empty()` function from PHP because values like `0` or `false` are
     * considered empty values, and we don't want this behavior.
     * @param mixed $value Value to be checked
     * @return bool
     */
    protected function isValueEmpty(mixed $value): bool
    {
        if ($value === '') {
            return true;
        } else if ($value === []) {
            return true;
        } else if ($value === null) {
            return true;
        }

        return false;
    }


    /**
     * Checks if a value's type is the expected.
     * @param mixed $value
     * @param array|string $expected A type name string or an array of type names
     * @return void
     */
    protected function expectValueTypeToBe(mixed $value, array|string $expected): bool
    {
        $type = $this->getType($value);
        return $this->isTypeValid($type, $expected);
    }


    /**
     * Compares a type name with another type name or is in a list of types
     * @param string $type Type name
     * @param array|string $expected A type name string or an array of type names
     * @return bool
     */
    protected function isTypeValid(string $type, array|string $expected): bool
    {
        if ($this->getType($expected) == 'array' && in_array($type, $expected, true)) {
            return true;
        } else if ($type === $expected) {
            return true;
        }

        return false;
    }
}
