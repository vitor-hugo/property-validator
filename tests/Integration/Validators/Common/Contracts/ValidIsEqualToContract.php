<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Common\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsEqualTo;


class ValidIsEqualToContract extends BaseValidationTestClass
{
    #[IsEqualTo("string")]
    public string $string = "string";

    #[IsEqualTo(["A", "B", "C"])]
    public array $array = ["A", "B", "C"];

    #[IsEqualTo(false)]
    public bool $bool = false;

    #[IsEqualTo(512)]
    public int $int = 512;

    #[IsEqualTo(3.1415)]
    public float $float = 3.1415;

    #[IsEqualTo(1024)]
    public mixed $mixed = 1024;
}
