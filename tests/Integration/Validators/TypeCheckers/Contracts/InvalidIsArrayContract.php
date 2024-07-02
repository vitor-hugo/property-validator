<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsArray;

class InvalidIsArrayContract extends BaseValidationTestClass
{
    #[IsArray()]
    public string $arr = "should be an array";
}
