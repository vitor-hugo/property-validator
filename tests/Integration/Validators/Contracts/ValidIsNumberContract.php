<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsNumber;

class ValidIsNumberContract extends BaseValidationTestClass
{
    #[IsNumber()]
    public int $num1 = 2048;

    #[IsNumber()]
    public float $num2 = 3.1415;

    #[IsNumber()]
    public mixed $num3 = 2048;

    #[IsNumber('Not a number!!!')]
    public mixed $num4 = 9.99;
}
