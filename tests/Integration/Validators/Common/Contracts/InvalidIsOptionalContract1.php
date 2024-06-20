<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Common\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;

class InvalidIsOptionalContract1 extends BaseValidationTestClass
{
    #[IsOptional()]
    public string $name = "My Name";
}
