<?php declare(strict_types=1);

namespace Tests\Integration\Contracts;

use Torugo\PropertyValidator\PropertyValidator;

abstract class StubValidation
{
    public function validate()
    {
        PropertyValidator::validate($this);
    }
}
