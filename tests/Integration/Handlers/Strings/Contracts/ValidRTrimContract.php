<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\RTrim;

class ValidRTrimContract extends BaseValidationTestClass
{
    #[RTrim()]
    public $default = "String    ";

    #[RTrim(" -=")]
    public $especific = "String === ---";

    #[RTrim("A..F")]
    public $range = "ABCDEFGFEDCBA";
}
