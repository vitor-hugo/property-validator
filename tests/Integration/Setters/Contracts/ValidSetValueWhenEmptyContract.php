<?php declare(strict_types=1);

namespace Tests\Integration\Setters\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Setters\SetValueWhenEmpty;

class ValidSetValueWhenEmptyContract extends BaseValidationTestClass
{
    #[SetValueWhenEmpty("default")]
    public string $var1 = "";

    #[SetValueWhenEmpty("default")]
    public ?string $var2 = null;

    #[SetValueWhenEmpty("mixed")]
    public mixed $var3 = null;
}
