<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsRequired;

class InvalidIsRequiredContract extends BaseValidationTestClass
{
    #[IsRequired()]
    public string|null $string = "Can't be optional";
}
