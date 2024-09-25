<?php declare(strict_types=1);

namespace Tests\Integration\Setters\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Setters\SetValueWhenNull;

class ValidSetValuesContract extends BaseValidationTestClass
{
    #[SetValueWhenNull("string")]
    public ?string $var1 = null;

    #[SetValueWhenNull(13)]
    public ?int $var2 = null;

    #[SetValueWhenNull(["a", "b"])]
    public mixed $var3 = null;
}
