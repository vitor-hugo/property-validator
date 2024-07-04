<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\LTrim;

class ValidLTrimContract extends BaseValidationTestClass
{
    #[LTrim()]
    public $default = "    String";

    #[LTrim(" -=")]
    public $especific = "--- === String";

    #[LTrim("A..E")]
    public $range = "ABCDEFG";
}
