<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\Append;

class ValidAppendContract extends BaseValidationTestClass
{
    #[Append(">")]
    #[Append("]")]
    #[Append("}")]
    #[Append(")")]
    public mixed $item = "";
}
