<?php declare(strict_types=1);

namespace Tests\Integration\Validators\DateTime\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;
use Torugo\PropertyValidator\Attributes\Validators\DateTime\MinDateTime;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDateTime;

define("_VAL_MIN_DATE", "2017-08-01 12:30:45");

class ValidMinDateTimeContract extends BaseValidationTestClass
{
    #[IsDateTime('Y-m-d H:i:s', true)]
    #[MinDateTime(new \DateTime(_VAL_MIN_DATE . " -2 days"))]
    public mixed $minDate = _VAL_MIN_DATE;

    #[MinDateTime(new \DateTime("now"))]
    public \DateTime $date;

    #[IsOptional()]
    #[MinDateTime(new \DateTime("now"))]
    public mixed $time = null;

    #[IsOptional()]
    #[MinDateTime(new \DateTime(_VAL_MIN_DATE))]
    public mixed $equals = null;
}
