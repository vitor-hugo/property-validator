<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use Torugo\TString\Traits\Validators\TStringIsLength;

/**
 * Validates if the length of a string is between a minimum and maximum parameters.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Length extends Validator
{
    use TStringIsLength;

    /**
     * If the minimum size is greater than the maximum, the values ​​will be swapped.
     *
     * @param int $min Minimum acceptable length. Must be >= 0.
     * @param int $max Maximum accpetable length. Must be >= 1.
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(
        private int $min,
        private int $max,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }

    public function validation(mixed $value): void
    {
        if ($this->min < 0) {
            throw new ValidationException("The MIN argument on '{$this->propertyName}' must be greater than or equal to zero.");
        }

        if ($this->max < 1) {
            throw new ValidationException("The MAX argument on '{$this->propertyName}' must be greater than zero.");
        }

        $this->expectPropertyTypeToBe(["string", "mixed"]);
        $this->expectPropertyValueToBe("string");

        if (self::isLength($value, $this->min, $this->max) === false) {
            $this->throwValidationException("The length of '{$this->propertyName}' must be at least {$this->min} and at most {$this->max}");
        }
    }
}
