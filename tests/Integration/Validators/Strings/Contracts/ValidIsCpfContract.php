<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsCpf;

class ValidIsCpfContract extends BaseValidationTestClass
{
    #[IsCpf()]
    public string $cpf = "532.625.750-54";

    #[IsCpf('Invalid CPF!!!')] // Custom error message
    public string $ohterCpf = "88479747048";
}
