<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\Numbers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;

/**
 * Validates if property's value is greater than a given number
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Max extends Validator
{
    /**
     * @param int|float $max Maximum acceptable number
     * @param string|null $errorMessage Message to be displayed in case of validation error.
     */
    public function __construct(private int|float $max, string|null $errorMessage = null)
    {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["int", "float", "mixed"]);
        $this->validateValueType($value);

        if ($value > $this->max) {
            $this->throwValidationException("Property '{$this->propertyName}' only accepts numbers up to {$this->max}, received {$value}.");
        }
    }


    private function validateValueType(mixed $value)
    {
        $type = $this->getType($value);
        if ($type !== "int" && $type != "float") {
            $this->throwValidationException("Property '{$this->propertyName}' must receive float or int values, received $type.");
        }
    }
}
