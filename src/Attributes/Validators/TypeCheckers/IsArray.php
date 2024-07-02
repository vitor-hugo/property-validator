<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates whether the value of a property is an array.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsArray extends Validator
{
    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["array", "mixed"]);
        $this->expectValueTypeToBe("array");
    }
}
