<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsAlphanumeric;

class ValidIsAlphanumericContract extends BaseValidationTestClass
{
    #[IsAlphanumeric()]
    public string $str1 = "mSfPq4Tc9ipPgX5487NG";

    #[IsAlphanumeric(true)] // include unicode chars
    public string $str2 = "çeY4â2e4SÇ8ÂdiÀÏKTLÊ";

    #[IsAlphanumeric(false, 'Only alphanumeric characters')] // Custom error message
    public string $str3 = "vikIgjBeMEzEqiAqMGKFHc";
}
