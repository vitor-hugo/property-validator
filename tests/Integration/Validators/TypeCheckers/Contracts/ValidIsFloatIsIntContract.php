<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDouble;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsFloat;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsInt;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsInteger;

class ValidIsFloatIsIntContract extends BaseValidationTestClass
{
    #[IsInt()]
    public int $int1 = 1983;

    #[IsInteger()]
    public ?int $int2 = 2017;

    #[IsInt()]
    public mixed $int3 = 13;

    #[IsInt('Invalid integer number!!!')]
    public mixed $int4 = PHP_INT_MAX;

    #[IsFloat()]
    public float $float1 = 1.6180;

    #[IsDouble()]
    public ?float $float2 = 3.14159265359;

    #[IsFloat()]
    public mixed $float3 = 2.7182;

    #[IsFloat('Invalid float number!!!')]
    public mixed $float4 = PHP_FLOAT_MAX;
}
