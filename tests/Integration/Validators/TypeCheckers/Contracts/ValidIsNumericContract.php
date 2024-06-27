<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsNumeric;

class ValidIsNumericContract extends BaseValidationTestClass
{
    #[IsNumeric()]
    public int $num1 = 2048;

    #[IsNumeric()]
    public float $num2 = 3.1415;

    #[IsNumeric()]
    public mixed $num3 = "1,999.99";

    #[IsNumeric('Not a number!!!')]
    public mixed $num4 = 9.99;
}
