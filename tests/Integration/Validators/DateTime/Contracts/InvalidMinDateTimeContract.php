<?php declare(strict_types=1);

namespace Tests\Integration\Validators\DateTime\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\DateTime\MinDateTime;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDateTime;

define("_INV_MIN_DATE", "2017-08-01 12:30:45");

class InvalidMinDateTimeContract extends BaseValidationTestClass
{
    #[IsDateTime()]
    #[MinDateTime(new \DateTime(_INV_MIN_DATE . " -1 day"))]
    public string $maxDate = _INV_MIN_DATE;
}
