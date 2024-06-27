<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Common;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Defines a property as optional, so its value can be empty or null.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsOptional extends Validator
{
    public function validation(mixed $value): void
    {
    }
}
