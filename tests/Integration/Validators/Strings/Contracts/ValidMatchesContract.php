<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Strings\Matches;

class ValidMatchesContract extends BaseValidationTestClass
{
    #[Matches("/^#(?:[0-9a-fA-F]{3}){1,2}$/")]
    public mixed $color = "#0ABAB5";

    #[Matches("/^[[:upper:]\s]+$/", "Uppercase letters only!")]
    public string $name = "LUKE SKYWALKER";
}
