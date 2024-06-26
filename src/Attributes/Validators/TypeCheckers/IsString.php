<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsString extends Validator
{
    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["string", "mixed"]);
        $this->expectValueTypeToBe("string");
    }
}
