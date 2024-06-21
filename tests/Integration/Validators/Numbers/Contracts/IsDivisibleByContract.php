<?php declare(strict_types=1);
use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Numbers\IsDivisibleBy;

class ValidIsDivisibleByContract extends BaseValidationTestClass
{
    #[IsDivisibleBy(2)]
    public int $num1 = 10;

    #[IsDivisibleBy(2.5)]
    public float $num2 = 7.5;

    #[IsDivisibleBy(4.6)]
    public mixed $num3 = 9.2;

    #[IsDivisibleBy(2, "Not divisible by 2")]
    public mixed $num4 = 30;
}


class InvalidIsDivisibleByContract extends BaseValidationTestClass
{
    #[IsDivisibleBy(2)]
    public string $number = "10";
}
