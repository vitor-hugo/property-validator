<?php declare(strict_types=1);
use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Numbers\IsPositive;

class ValidIsPositiveContract extends BaseValidationTestClass
{
    #[IsPositive()]
    public int $num1 = 10;

    #[IsPositive()]
    public float $num2 = 9.99;

    #[IsPositive()]
    public mixed $num3 = 1512.32;

    #[IsPositive("Don't be so negative!")]
    public mixed $num4 = 83;
}


class InvalidIsPositiveContract extends BaseValidationTestClass
{
    #[IsPositive()]
    public string $ammount = "10";
}
