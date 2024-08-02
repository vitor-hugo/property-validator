<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Common\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Common\CopyFrom;

class ValidCopyFromContract extends BaseValidationTestClass
{
    public mixed $target = "X";

    #[CopyFrom("target")]
    public string $copy = "Y";
}
