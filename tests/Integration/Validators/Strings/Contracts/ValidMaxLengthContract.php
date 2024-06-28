<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\MaxLength;

class ValidMaxLengthContract extends BaseValidationTestClass
{
    #[MaxLength(30)]
    public $str1 = "ca8ec7ff85a0e973ac076479";

    #[MaxLength(16, "Exceeded Max Length!")]
    public $str2 = "a8103293446fb0c5";
}
