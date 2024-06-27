<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\Length;

class ValidLengthContract extends BaseValidationTestClass
{
    #[Length(10, 20)]
    public $str1 = "On the Same Page";

    #[Length(8, 100, 'Invalid password length.')]
    public $password = "Don't Count Your Chickens Before They Hatch";
}
