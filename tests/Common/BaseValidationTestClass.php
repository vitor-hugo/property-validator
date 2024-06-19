<?php declare(strict_types=1);

namespace Tests\Common;

use Torugo\PropertyValidator\PropertyValidator;

abstract class BaseValidationTestClass
{
    public function validate()
    {
        PropertyValidator::validate($this);
    }
}
