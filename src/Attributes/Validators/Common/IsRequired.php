<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Common;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\PropertyValidator\Exceptions\ValidationException;

/**
 * Defines a property as required, therefore it is not nullable
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsRequired extends Validator
{
    public function validation(mixed $value): void
    {
        if ($this->isOptional()) {
            throw new ValidationException("The property '{$this->propertyName}' cannot be REQUIRED and OPTIONAL at the same time.");
        }

        if ($this->isEmpty($value)) {
            $this->throwValidationException("The property '{$this->propertyName}' is required.'");
        }
    }
}
