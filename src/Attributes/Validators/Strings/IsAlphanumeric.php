<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringIsAlphanumeric;

/**
 * Validates if a string have only alphanumeric characters.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsAlphanumeric extends IsString
{
    use TStringIsAlphanumeric;

    /**
     * @param bool $includeUnicode Includes some Unicode alphabetic chars like accented letters. (default false)
     * @param string|null $errorMessage Custom error message
     */
    public function __construct(
        private bool $includeUnicode = false,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::isAlphanumeric($value, $this->includeUnicode) == false) {
            $this->throwValidationException("Property '{$this->propertyName}' can only have alphanumeric characters.");
        }
    }
}
