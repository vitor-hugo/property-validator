<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Numbers;

use Attribute;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsNumeric;

/**
 * Validates whether a number falls within a given inclusive range.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Range extends IsNumeric
{
    /**
     * @param int|float $min Minimum acceptable number
     * @param int|float $max Minimum acceptable number
     * @param string|null $errorMessage Message to be displayed in case of validation error.
     */
    public function __construct(
        private int|float $min,
        private int|float $max,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        parent::validation($value);

        $min = $this->min;
        $max = $this->max;

        if ($min === $max) {
            $this->throwValidationException("The MIN and MAX arguments of the RANGE attribute must not be the same.");
        }

        if ($min > $max) {
            [$min, $max] = [$max, $min];
        }

        if ($value < $min || $value > $max) {
            $this->throwValidationException("Value $value on '{$this->propertyName}' must be between $min and $max.");
        }
    }
}
