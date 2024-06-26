<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use Torugo\TString\Traits\Validators\TStringContains;

/**
 * Checks if a substring is contained in another string.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class NotContains extends IsString
{
    use TStringContains;

    /**
     * @param string $forbidden The substring that can't be contained in the property's value
     * @param bool $caseSensitive Should be case sensitive? default `true`
     * @param string|null $errorMessage
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

        if (self::contains($value, $this->substring, $this->caseSensitive)) {
            throw new ValidationException("Property '{$this->propertyName}' cannot contains '{$this->substring}'.");
        }
    }
}
