<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\IsSemVer;

class ValidIsSemVerContract extends BaseValidationTestClass
{
    #[IsSemVer()]
    public string $version = "1.0.0-beta.1+123";

    #[IsSemVer('Invalid version number!!!')] // Custom error message
    public string $otherVersion = "1.0.0-beta.1+123";
}
