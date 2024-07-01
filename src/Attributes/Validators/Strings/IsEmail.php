<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringIsEmail;

/**
 * Validates whether a string has a valid email structure.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsEmail extends IsString
{
    use TStringIsEmail;

    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::IsEmail($value) == false) {
            $this->throwValidationException("The email '$value' is not valid.");
        }
    }
}
