<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use Torugo\TString\Traits\Validators\TStringMinLength;

/**
 * Validates if the length of a string is greater than or equal to a minimum parameter.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class MinLength extends Validator
{
    use TStringMinLength;

    /**
     * @param int $min Minimum acceptable length. Must be >= 1.
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(
        private int $min,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        if ($this->min < 1) {
            throw new ValidationException("The MIN argument on '{$this->propertyName}' must be greater than zero.");
        }

        $this->expectPropertyTypeToBe(["string", "mixed"]);
        $this->expectPropertyValueToBe("string");

        if (self::minLength($value, $this->min) === false) {
            $len = mb_strlen($value);
            $this->throwValidationException("The length of '{$this->propertyName}' must be at least {$this->min}, $len received.");
        }
    }
}
