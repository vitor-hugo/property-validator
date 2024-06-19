<?php declare(strict_types=1);

namespace Tests\Integration\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsRequired;

class ValidIsRequiredContract extends BaseValidationTestClass
{
    #[IsRequired()]
    public string $string = "My String";

    #[IsRequired()]
    public mixed $mixed = ["mixed", "type"];

    #[IsRequired("Password is required!")]
    public string $password = "MySuperStrongPassword!";
}
