<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDateTime;

class InvalidIsDateTimeContract extends BaseValidationTestClass
{
    #[IsDateTime(toDateTime: true)]
    public string $dt1 = "2017-08-01 14:45:00";
}
