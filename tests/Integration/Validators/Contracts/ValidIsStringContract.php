<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;

class ValidIsStringContract extends BaseValidationTestClass
{
    #[IsString()]
    public string $str1 = "Cecília Meireles";

    #[IsString()]
    public ?string $str2 = "Optional String";

    #[IsString()]
    public mixed $str3 = "Mixed Type";

    #[IsString("Not a String!!!")]
    public mixed $str4 = "This is a string";
}
