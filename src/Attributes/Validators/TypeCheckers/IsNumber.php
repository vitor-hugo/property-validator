<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates if a value's type is INT or FLOAT.
 *
 * To check if is a numeric string use IsNumeric validator.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsNumber extends Validator
{
    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["int", "float", "mixed"]);

        $type = $this->getType($value);

        if ($type !== 'float' && $type !== 'int') {
            $this->throwValidationException("Property '{$this->propertyName}' must receive integer or float values, $type received.");
        }
    }
}
