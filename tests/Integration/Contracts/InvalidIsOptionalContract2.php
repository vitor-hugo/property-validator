<?php declare(strict_types=1);

namespace Tests\Integration\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsRequired;

class InvalidIsOptionalContract2 extends BaseValidationTestClass
{
    #[IsOptional()]
    #[IsRequired()]
    public mixed $name = "My Name";
}
