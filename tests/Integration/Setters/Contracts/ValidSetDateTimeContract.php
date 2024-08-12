<?php declare(strict_types=1);

namespace Tests\Integration\Setters\Contracts;

use DateTime;
use DateTimeZone;
use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Setters\SetDateTime;

class ValidSetDateTimeContract extends BaseValidationTestClass
{
    #[SetDateTime()]
    public DateTime $dt1;

    #[SetDateTime("now", null, new DateTimeZone("America/Sao_Paulo"))]
    public mixed $dt2;

    #[SetDateTime("now", "Y-m-d H:i:s", new DateTimeZone("America/Sao_Paulo"))]
    public mixed $dt3;
}
