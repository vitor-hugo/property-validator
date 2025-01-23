<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsTUID;

class ValidIsTUIDContract extends BaseValidationTestClass
{
    #[IsTUID()]
    public string $short = "UU5IM7L-TS0SQK0Y3101";

    #[IsTUID()]
    public string $medium = "V6ZS389O-SMXM-TM0SQK0Y3116";

    #[IsTUID("Invalid ID!")] // Custom error message
    public string $long = "VPD1QAMA-XBFK-AVF7SSP67-TL0SQK0Y311B";
}
