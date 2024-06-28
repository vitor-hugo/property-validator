<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\TString\Traits\Validators\TStringMaxLength;

/**
 * Validates if the length of a string is lesser than or equal to a maximum parameter.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class MaxLength extends Validator
{
    use TStringMaxLength;

    /**
     * @param int $max Maximum accpetable length. Must be >= 1, if lesser will be setted to 1.
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(
        private int $max,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }

    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["string", "mixed"]);
        $this->expectPropertyValueToBe("string");

        if (self::maxLength($value, $this->max) === false) {
            $len = mb_strlen($value);
            $this->throwValidationException("The length of '{$this->propertyName}' can be at most {$this->max}, $len received.");
        }
    }
}
