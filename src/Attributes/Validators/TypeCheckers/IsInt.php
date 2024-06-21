<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates if a value's type is INT.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInt extends Validator
{
    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["int", "mixed"]);

        $type = $this->getType($value);

        if ($type !== "int") {
            $this->throwValidationException("Property '{$this->propertyName}' must receive int values, received $type.");
        }
    }
}
