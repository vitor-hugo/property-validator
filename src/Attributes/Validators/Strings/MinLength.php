<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Strings;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsString;
use Torugo\TString\Traits\Validators\TStringMinLength;

/**
 * Validates if the length of a string is greater than or equal to a minimum parameter.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class MinLength extends IsString
{
    use TStringMinLength;

    /**
     * @param int $min Minimum acceptable length. Must be >= 0. If negative will be setted to zero.
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
        parent::validation($value);

        if (self::minLength($value, $this->min) === false) {
            $len = mb_strlen($value);
            $this->throwValidationException("The length of '{$this->propertyName}' must be at least {$this->min}, $len received.");
        }
    }
}
