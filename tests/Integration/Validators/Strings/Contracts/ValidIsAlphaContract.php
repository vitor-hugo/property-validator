<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsAlpha;

class ValidIsAlphaContract extends BaseValidationTestClass
{
    #[IsAlpha()]
    public string $str1 = "UZoljlNxrCYJUpDgmDmCA";

    #[IsAlpha(true)] // include unicode chars
    public string $str2 = "XOÄfsàugKjLcpGEJÄwbvàX";

    #[IsAlpha(false, 'Only alphabetic characters')] // Custom error message
    public string $str3 = "vikIgjBeMEzEqiAqMGKFHc";
}
