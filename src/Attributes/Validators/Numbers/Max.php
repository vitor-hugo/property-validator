<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Numbers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates whether a number is less than or equal to a given number.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Max extends Validator
{
    /**
     * @param int|float $max Maximum acceptable number
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(private int|float $max, string|null $errorMessage = null)
    {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["int", "float", "mixed"]);
        $this->expectValueTypeToBe(["int", "float"]);

        if ($value > $this->max) {
            $this->throwValidationException("Property '{$this->propertyName}' only accepts numbers up to {$this->max}, received {$value}.");
        }
    }
}
