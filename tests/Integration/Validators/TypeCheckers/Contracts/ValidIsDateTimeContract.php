<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDateTime;

class ValidIsDateTimeContract extends BaseValidationTestClass
{
    #[IsDateTime()]
    public string $dt1 = "2017-08-01 14:45:00";

    #[IsDateTime(format: "m/d/Y")]
    public string $dt2 = "01/03/1892";

    #[IsDateTime(convertToDateTimeObject: true)]
    public mixed $dt3 = "2024-06-20 14:54:37";

    #[IsDateTime("d/m/Y H:i", true, errorMessage: "Invalid Date/Time String!!!!")]
    public mixed $dt4 = "13/03/1983 13:30";
}
