<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsBoolean;

class ValidIsBooleanContract extends BaseValidationTestClass
{
    #[IsBoolean(convertToBoolean: false)]
    public bool $var1 = true;

    #[IsBoolean(convertToBoolean: true)]
    public mixed $var2 = "false";

    #[IsBoolean(convertToBoolean: false)]
    public mixed $var3 = "no";

    #[IsBoolean(convertToBoolean: false, errorMessage: "Not a valid boolean value!!!")]
    public mixed $var4 = "yes";
}
