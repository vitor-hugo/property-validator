<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayNotContains;

class ValidArrayNotContainsContract extends BaseValidationTestClass
{
    #[ArrayNotContains("pineapple")]
    public $arr1 = ["apple", "banana", "grapes", "orange"];

    #[ArrayNotContains("30", true)]
    public $arr2 = [10, 20, 30, 40];

    #[ArrayNotContains(50, false)]
    public $arr3 = ["10", "20", "30", "40"];

    #[ArrayNotContains("Luke")]
    public $arr4 = ["firstName" => "Han", "lasName" => "Solo"];

    #[ArrayNotContains(["31", "41"])]
    public $arr5 = ["10", "20", ["30", "40"]];

    #[ArrayNotContains("pineapple", true, "Alergic to pineappe!!!")]
    public $arr6 = ["apple", "banana", "grapes", "orange"];
}
