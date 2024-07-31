<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Common;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates whether the value of a property exactly equals to a given value.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsEqualTo extends Validator
{
    public function __construct(
        private mixed $expected,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }

    public function validation(mixed $value): void
    {
        if ($value !== $this->expected) {
            $this->throwValidationException("Invalid value for '{$this->propertyName}'.");
        }
    }
}
