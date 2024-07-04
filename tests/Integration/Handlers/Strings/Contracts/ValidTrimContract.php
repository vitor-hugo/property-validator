<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Trim;

class ValidTrimContract extends BaseValidationTestClass
{
    #[Trim()]
    public $default = "    String    ";

    #[Trim(" -=")]
    public $especific = "--- String ===";

    #[Trim("A..E")]
    public $range = "ABCDEFGFEDCBA";
}
