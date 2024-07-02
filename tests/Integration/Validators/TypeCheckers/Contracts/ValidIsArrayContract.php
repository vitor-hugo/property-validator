<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsArray;

class ValidIsArrayContract extends BaseValidationTestClass
{
    #[IsArray()]
    public array $arr1 = ["apple", "banana", "grapes", "orange"];

    #[IsArray()]
    public ?array $arr2 = ["10", 20, [30, "40"], 50];

    #[IsArray()]
    public mixed $arr3 = ["firstName" => "Jhon", "lasName" => "Appleseed"];

    #[IsArray("This is not an array!")]
    public mixed $arr4 = ["This is an array"];
}
