<?php declare(strict_types=1);
use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Numbers\Max;

class ValidMaxContract extends BaseValidationTestClass
{
    #[Max(20)]
    public int $num1 = 10;

    #[Max(19.99)]
    public float $num2 = 9.99;

    #[Max(1999.99)]
    public mixed $num3 = 1512.32;

    #[Max(100, "The number can't be greater than 100")]
    public mixed $num4 = 83;
}


class InvalidMaxContract extends BaseValidationTestClass
{
    #[Max(20)]
    public string $ammount = "10";
}
