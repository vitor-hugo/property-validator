<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Common\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Common\CopyFrom;

class InvalidCopyFromContract extends BaseValidationTestClass
{
    #[CopyFrom("target")]
    public mixed $copy = "Y";
}
