<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Numbers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates whether a number is greater than or equal to a given number.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Min extends Validator
{
    /**
     * @param int|float $min Minimum acceptable number.
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(private int|float $min, string|null $errorMessage = null)
    {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["int", "float", "mixed"]);
        $this->expectValueTypeToBe(["int", "float"]);

        if ($value < $this->min) {
            $this->throwValidationException("Property '{$this->propertyName}' only accepts numbers greater than or equal to {$this->min}, received {$value}.");
        }
    }
}
