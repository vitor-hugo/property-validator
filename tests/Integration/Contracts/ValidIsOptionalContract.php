<?php declare(strict_types=1);

namespace Tests\Integration\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;

class ValidIsOptionalContract extends BaseValidationTestClass
{
    #[IsOptional()]
    public ?string $string = null;

    #[IsOptional()]
    public ?array $array = [];

    #[IsOptional()]
    public mixed $mixed = null;
}
