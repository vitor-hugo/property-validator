<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Numbers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates if property's value is positive (greater than zero)
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsPositive extends Validator
{
    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["int", "float", "mixed"]);
        $this->validateValueType($value);

        if ($value <= 0) {
            $this->throwValidationException("Property '{$this->propertyName}' only accepts positive numbers, received {$value}.");
        }
    }


    private function validateValueType(mixed $value)
    {
        $type = $this->getType($value);
        if ($type !== "int" && $type !== "float") {
            $this->throwValidationException("Property '{$this->propertyName}' must receive float or int values, received $type.");
        }
    }
}
