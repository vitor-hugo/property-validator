<?php declare(strict_types=1);

namespace Tests\Integration\Validators\DateTime\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;
use Torugo\PropertyValidator\Attributes\Validators\DateTime\MaxDateTime;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDateTime;

define("_VAL_MAX_DATE", "2017-08-01 12:30:45");

class ValidMaxDateTimeContract extends BaseValidationTestClass
{
    #[IsDateTime('Y-m-d H:i:s', true)]
    #[MaxDateTime(new \DateTime(_VAL_MAX_DATE . " +2 days"))]
    public mixed $maxDate = _VAL_MAX_DATE;

    #[MaxDateTime(new \DateTime("now +2 days"))]
    public \DateTime $date;

    #[IsOptional()]
    #[MaxDateTime(new \DateTime("now"))]
    public mixed $time = null;

    #[IsOptional()]
    #[MaxDateTime(new \DateTime(_VAL_MAX_DATE))]
    public mixed $equals = null;
}
