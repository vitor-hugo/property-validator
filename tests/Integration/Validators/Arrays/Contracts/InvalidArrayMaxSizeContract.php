<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Validators\Arrays\ArrayMaxSize;

class InvalidArrayMaxSizeContract extends BaseValidationTestClass
{
    #[ArrayMaxSize(0)]
    public $arr1 = ["A"];
}
