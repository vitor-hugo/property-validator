<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Tests\Integration\Validators\TypeCheckers\Contracts\Enums\ValidIntEnum;
use Tests\Integration\Validators\TypeCheckers\Contracts\Enums\ValidStringEnum;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsEnum;

class ValidIsEnumContract extends BaseValidationTestClass
{
    #[IsEnum(ValidStringEnum::class)]
    public string $var1 = "L";

    #[IsEnum(ValidIntEnum::class)]
    public int $var2 = 3;

    #[IsEnum(ValidStringEnum::class)]
    public mixed $var3 = "M";

    #[IsEnum(ValidIntEnum::class, "Invalid Database ID")]
    public mixed $var4 = 1;
}
