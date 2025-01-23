<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\SubString;

class ValidSubStringContract extends BaseValidationTestClass
{
    #[SubString(0, 3)]
    public $var1 = "abcdef";

    #[SubString(-1)]
    public $var2 = "abcdef";

    #[SubString(0, -1)]
    public $var3 = "abcdef";

    #[SubString(4, -4)]
    public $var4 = "abcdef";
}
