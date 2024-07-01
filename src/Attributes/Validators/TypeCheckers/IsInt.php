<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates whether the value of a property is of type integer.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInt extends Validator
{
    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["int", "mixed"]);
        $this->expectValueTypeToBe("int");
    }
}
