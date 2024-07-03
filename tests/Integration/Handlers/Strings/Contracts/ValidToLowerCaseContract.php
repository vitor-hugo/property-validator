<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings\Contracts;

use Tests\Common\BaseValidationTestClass;
use Torugo\PropertyValidator\Attributes\Handlers\Strings\ToLowerCase;

class ValidToLowerCaseContract extends BaseValidationTestClass
{
    #[ToLowerCase()]
    public mixed $item = "";
}
