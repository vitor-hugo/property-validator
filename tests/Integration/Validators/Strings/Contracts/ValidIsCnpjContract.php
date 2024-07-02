<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsCnpj;

class ValidIsCnpjContract extends BaseValidationTestClass
{
    #[IsCnpj()]
    public string $cnpj = "99.453.669/0001-04";

    #[IsCnpj('Invalid CNPJ!!!')] // Custom error message
    public string $ohterCnpj = "60391682000132";
}
