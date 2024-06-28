<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Common;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Defines a property as required, so that the value cannot be null or empty.
 *
 * By default, all properties of a class that use any of the attributes in this
 * library are treated as not nullable, using this attribute the value can't
 * be empty as well.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsRequired extends Validator
{
    public function validation(mixed $value): void
    {
        if ($this->isValueEmpty($value)) {
            $this->throwValidationException("Property '{$this->propertyName}' is required.");
        }
    }
}
