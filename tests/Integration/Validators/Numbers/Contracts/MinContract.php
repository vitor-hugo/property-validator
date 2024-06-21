<?php declare(strict_types=1);
use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Numbers\Min;

class ValidMinContract extends BaseValidationTestClass
{
    #[Min(0)]
    public int $num1 = 10;

    #[Min(19.99)]
    public float $num2 = 32.44;

    #[Min(1000)]
    public mixed $num3 = 1512;

    #[Min(80, "The number can't be lesser than 80")]
    public mixed $num4 = 83;
}


class InvalidMinContract extends BaseValidationTestClass
{
    #[Min(20)]
    public string $ammount = "30";
}
