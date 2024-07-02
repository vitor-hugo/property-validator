<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsNumeric;

class InvalidIsNumericContract extends BaseValidationTestClass
{
    #[IsNumeric()]
    public array $num1 = [2048];
}
