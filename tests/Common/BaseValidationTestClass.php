<?php declare(strict_types=1);

namespace Tests\Common;

use Torugo\PropertyValidator\PropertyValidator;

abstract class BaseValidationTestClass
{
    public function validate(): bool
    {
        try {
            PropertyValidator::validate($this);
        } catch (\Throwable $th) {
            throw $th;
        }

        return true;
    }
}
