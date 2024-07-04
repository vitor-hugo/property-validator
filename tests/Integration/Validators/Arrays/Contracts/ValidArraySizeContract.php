<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayMaxSize;
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayMinSize;

class ValidArraySizeContract extends BaseValidationTestClass
{
    #[ArrayMaxSize(3)]
    public $arr1 = ["A", "B", "C"];

    #[ArrayMinSize(2)]
    public $arr2 = ["A", "B", "C"];

    #[ArrayMinSize(3)]
    #[ArrayMaxSize(6)]
    public $arr3 = [1, 2, 3, 4, 5];

    #[ArrayMinSize(3, "Too Few")]
    #[ArrayMaxSize(6, "Too Mutch")]
    public $arr4 = [1, 2, 3, 4, 5];
}
