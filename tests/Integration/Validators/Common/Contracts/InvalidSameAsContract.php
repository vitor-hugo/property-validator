<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Common\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;
use Torugo\PropertyValidator\Attributes\Validators\Common\SameAs;

class InvalidSameAsContract extends BaseValidationTestClass
{
    #[IsOptional()]
    public mixed $propA = "MZ1WTIzZRkChLL5nR839+1lv";

    #[IsOptional()]
    #[SameAs('propC')] // Not exists
    public mixed $propB = "MZ1WTIzZRkChLL5nR839+1lv";
}