<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use Torugo\TString\Traits\Validators\TStringContains;

/**
 * Validates whether a substring is contained in the value of a property.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Contains extends IsString
{
    use TStringContains;

    /**
     * @param string $substring The substring to search for in the property's value
     * @param bool $caseSensitive Should be case sensitive? default `true`
     * @param string|null $errorMessage Custom error message
     */
    public function __construct(
        private string $substring,
        private bool $caseSensitive = true,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        parent::validation($value);

        if (self::contains($value, $this->substring, $this->caseSensitive) == false) {
            throw new ValidationException("Property '{$this->propertyName}' not contains '{$this->substring}'.");
        }
    }
}
