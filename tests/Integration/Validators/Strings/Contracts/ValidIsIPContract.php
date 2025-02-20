<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsIP;

class ValidIsIPContract extends BaseValidationTestClass
{
    #[IsIP(4)]
    public string $ip4 = "127.0.0.1";

    #[IsIP(6)]
    public string $ip6 = "64:ff9b::192.0.2.33";

    #[IsIP(0, 'Invalid IP address!!!')] // Custom error message
    public string $ipAddress = "0:0:0:0:0:0:10.0.0.1";
}
