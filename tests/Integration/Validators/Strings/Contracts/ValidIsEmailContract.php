<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsEmail;

class ValidIsEmailContract extends BaseValidationTestClass
{
    #[IsEmail()]
    public string $email = "email@host.com";

    #[IsEmail('Invalid email!!!')] // Custom error message
    public string $otherEmail = "email@host.com";
}
