<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringIsAlpha;

/**
 * Validates if a string have only alphabetical characters.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsAlpha extends IsString
{
    use TStringIsAlpha;

    /**
     * @param bool $includeUnicode Includes some unicode alphabet chars like accented letters. (default false)
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

        if (self::isAlpha($value, $this->includeUnicode) == false) {
            $this->throwValidationException("Property '{$this->propertyName}' can only have alphabetical characters.");
        }
    }
}
