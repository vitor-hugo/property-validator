<?php declare(strict_types=1);
use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Numbers\IsNegative;

class ValidIsNegativeContract extends BaseValidationTestClass
{
    #[IsNegative()]
    public int $num1 = -10;

    #[IsNegative()]
    public float $num2 = -3.1415;

    #[IsNegative()]
    public mixed $num3 = -5;

    #[IsNegative("Why be so positive!?")]
    public mixed $num4 = -29.99;
}


class InvalidIsNegativeContract extends BaseValidationTestClass
{
    #[IsNegative()]
    public string $ammount = "-1000";
}
