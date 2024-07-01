<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringIsBase64;

/**
 * Validates whether a string is in Base64 format.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsBase64 extends IsString
{
    use TStringIsBase64;

    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::IsBase64($value) == false) {
            $this->throwValidationException("Invalid Base64 string value on property '{$this->propertyName}'.");
        }
    }
}
