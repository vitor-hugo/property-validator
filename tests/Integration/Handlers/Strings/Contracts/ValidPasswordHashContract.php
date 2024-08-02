<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\PasswordHash;

class ValidPasswordHashContract extends BaseValidationTestClass
{
    #[PasswordHash()]
    public mixed $pass1 = "";

    #[PasswordHash(PASSWORD_ARGON2I)]
    public mixed $pass2 = "";

    #[PasswordHash(PASSWORD_BCRYPT, ["cost" => 10])]
    public mixed $pass3 = "";
}
