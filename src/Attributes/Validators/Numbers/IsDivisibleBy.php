<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Numbers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates whether a number is divisible by a given one
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsDivisibleBy extends Validator
{
    /**
     * @param int|float $divisor The divisor number.
     * @param string|null $errorMessage Message to be displayed in case of validation error.
     */
    public function __construct(private int|float $divisor, string|null $errorMessage = null)
    {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $dividend): void
    {
        $this->expectPropertyTypeToBe(["int", "float", "mixed"]);
        $this->validateDividend($dividend);

        $modulo = fmod($dividend, $this->divisor);

        if ($modulo != 0) {
            $this->throwValidationException("The number $dividend on property '{$this->propertyName}', is not divisible by {$this->divisor}.");
        }
    }


    private function validateDividend(mixed $dividend)
    {
        $type = $this->getType($dividend);
        if ($type !== "int" && $type !== "float") {
            $this->throwValidationException("Property '{$this->propertyName}' must receive float or int values, received $type.");
        }
    }
}
