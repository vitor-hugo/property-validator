<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Common;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Defines that the property can be empty, but not null.
 * This attribute cannot be used in conjunction with `IsOptional` validator.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class NotNull extends Validator
{
    public function validation(mixed $value): void
    {
    }
}
