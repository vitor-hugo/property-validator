<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsBase64;

class ValidIsBase64Contract extends BaseValidationTestClass
{
    #[IsBase64()]
    public string $str1 = "JR1+WDcLkokpBA==";

    #[IsBase64('Invalid Base64!!!')] // Custom error message
    public string $str2 = "vCA+bc7/jQok5yWlmgJm8g==";
}
