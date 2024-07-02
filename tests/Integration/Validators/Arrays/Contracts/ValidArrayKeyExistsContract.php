<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayKeyExists;

class ValidArrayKeyExistsContract extends BaseValidationTestClass
{
    #[ArrayKeyExists(["firstName", "lastName"], true)]
    public $arr1 = [
        "firstName" => "Luke",
        "lastName" => "Skywalker"
    ];

    #[ArrayKeyExists(["firstName", "lastName"], false)]
    public $arr2 = [
        "firstName" => "Luke",
        "lastName" => "Skywalker"
    ];

    #[ArrayKeyExists(["foo", 100], true, "Invalid List!!!")]
    public $arr3 = [
        "foo" => "bar",
        "bar" => "foo",
        100 => 100,
        "100" => "100"
    ];
}
