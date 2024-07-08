<?php declare(strict_types=1);

namespace Tests\Integration\Validators\DateTime\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\DateTime\MaxDateTime;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDateTime;

define("_INV_MAX_DATE", "2017-08-01 12:30:45");

class InvalidMaxDateTimeContract extends BaseValidationTestClass
{
    #[IsDateTime()]
    #[MaxDateTime(new \DateTime(_INV_MAX_DATE . " +2 days"))]
    public string $maxDate = _INV_MAX_DATE;
}
