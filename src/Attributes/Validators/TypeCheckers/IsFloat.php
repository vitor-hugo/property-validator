<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates if a value's type is FLOAT.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsFloat extends Validator
{
    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["float", "mixed"]);

        $type = $this->getType($value);

        if ($type !== "float" && $type !== "int") {
            $this->throwValidationException("Property '{$this->propertyName}' must receive float values, received $type.");
        }
    }
}
