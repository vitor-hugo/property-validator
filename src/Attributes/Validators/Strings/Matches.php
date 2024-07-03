<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;

/**
 * Performs a regular expression match on property's value
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Matches extends IsString
{
    /**
     * @param string $pattern The regex pattern to search for, as a string.
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(
        private string $pattern,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }

    public function validation(mixed $value): void
    {
        parent::validation($value);

        $matched = @preg_match_all($this->pattern, $value);

        if ($matched === false) {
            $error = $this->getRegexError();
            $this->throwValidationException("Property {$this->propertyName}: $error");
        }

        if ($matched === 0) {
            $this->throwValidationException("The the value of '{$this->propertyName}' is invalid.");
        }
    }


    private function getRegexError(): string|false
    {
        $errors = [
            PREG_NO_ERROR => false,
            PREG_INTERNAL_ERROR => "There was an internal PCRE error",
            PREG_BACKTRACK_LIMIT_ERROR => "Backtrack limit was exhausted",
            PREG_RECURSION_LIMIT_ERROR => "Recursion limit was exhausted",
            PREG_BAD_UTF8_ERROR => "The offset didn't correspond to the begin of a valid UTF-8 code point",
            PREG_BAD_UTF8_OFFSET_ERROR => "Malformed UTF-8 data",
        ];

        return $errors[preg_last_error()];
    }
}
