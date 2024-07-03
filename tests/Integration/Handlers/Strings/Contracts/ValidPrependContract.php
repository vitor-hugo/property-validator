<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Prepend;

class ValidPrependContract extends BaseValidationTestClass
{
    #[Prepend("4 ")]
    #[Prepend("3 ")]
    #[Prepend("2 ")]
    #[Prepend("1 ")]
    public mixed $item = "";
}
