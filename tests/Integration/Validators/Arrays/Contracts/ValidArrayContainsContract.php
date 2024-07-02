<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayContains;

class ValidArrayContainsContract extends BaseValidationTestClass
{
    #[ArrayContains("banana")]
    public $arr1 = ["apple", "banana", "grapes", "orange"];

    #[ArrayContains(20, true)]
    public $arr2 = [10, 20, 30, 40];

    #[ArrayContains(20, false)]
    public $arr3 = ["10", "20", "30", "40"];

    #[ArrayContains("Appleseed")]
    public $arr4 = ["firstName" => "Jhon", "lasName" => "Appleseed"];

    #[ArrayContains(["30", "40"])]
    public $arr5 = ["10", "20", ["30", "40"]];

    #[ArrayContains("banana", true, "Invalid List!!!")]
    public $arr6 = ["apple", "banana", "grapes", "orange"];
}
