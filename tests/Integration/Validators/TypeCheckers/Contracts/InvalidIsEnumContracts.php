<?php declare(strict_types=1);

use Tests\Common\BaseValidationTestClass;
use Tests\Integration\Validators\TypeCheckers\Contracts\Enums\InvalidEnum;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsEnum;

class NonexistentEnum extends BaseValidationTestClass
{
    #[IsEnum("Tests\Integration\XYZ")]
    public mixed $var1 = "X";
}

class NotBackedEnum extends BaseValidationTestClass
{
    #[IsEnum(InvalidEnum::class)]
    public mixed $var2 = "X";
}

