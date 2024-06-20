<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsBoolean;

class InvalidIsBooleanContract extends BaseValidationTestClass
{
    #[IsBoolean(true)]
    public bool $var1 = true;
}
