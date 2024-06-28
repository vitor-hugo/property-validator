<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\MinLength;

class ValidMinLengthContract extends BaseValidationTestClass
{
    #[MinLength(10)]
    public $str1 = "b1e26d60965f";

    #[MinLength(32, "Very few characters!")]
    public $str2 = "17004062692ee95a4bc7bc73bdab825bcc956041";
}
