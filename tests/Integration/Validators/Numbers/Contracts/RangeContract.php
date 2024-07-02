<?php declare(strict_types=1);
use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Numbers\Range;

class ValidRangeContract extends BaseValidationTestClass
{
    #[Range(0, 100)]
    public $percent = 54.7;

    #[Range(1.99, 12.99)]
    public $price = "9.99";

    #[Range(10, 0)] // swap min and max
    public $swap = 5;

    #[Range(-50, 0, "Not in range!")]
    public $custom = 0;
}


class InvalidRangeContract extends BaseValidationTestClass
{
    #[Range(0, 20)]
    public string $ammount = "10";
}
