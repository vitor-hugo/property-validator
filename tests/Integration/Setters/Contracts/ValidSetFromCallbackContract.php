<?php declare(strict_types=1);

namespace Tests\Integration\Setters\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Setters\SetFromCallback;

class ValidSetFromCallbackContract extends BaseValidationTestClass
{
    #[SetFromCallback("mt_rand", [10, 50])]
    public int $random = 0;

    #[SetFromCallback([ValueSetterClass::class, "sum"], [10, 15])]
    public int $sum = 0;

    #[SetFromCallback([self::class, "str"])]
    public string $str = "";


    public static function str(): string
    {
        return "my string";
    }
}
