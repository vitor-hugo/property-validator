<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;

/**
 * Validates wheter a property value is a valid boolean value
 *
 * - Values evaluated as **TRUE**: `true` , `1`, `'1'`, `'true'`, `'ok'`, `'yes'`, `'y'`, `'sim'` and `'s'`
 * - Values evaluated as **FALSE**: `false`, `0`, `'0'`, `'false'`, `'no'`, `'not'`, `'n'`, `'não'` and `'nao'`
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsBoolean extends Validator
{
    private const ACCEPTED_VALUES = [
        1 => true,
        "1" => true,
        "true" => true,
        "ok" => true,
        "yes" => true,
        "y" => true,
        "sim" => true,
        "s" => true,
        0 => false,
        "0" => false,
        "false" => false,
        "no" => false,
        "not" => false,
        "n" => false,
        "não" => false,
        "nao" => false,
    ];


    /**
     * @param bool $convertToBoolean Converts the received value to boolean (default = false), if you enable it assure that you defined the parameter as 'mixed'.
     * @param string|null $errorMessage Message to be displayed in case of validation error.
     */
    public function __construct(private bool $convertToBoolean = false, string|null $errorMessage = null)
    {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["bool", "mixed"]);

        if ($this->convertToBoolean == true && $this->propertyType != "mixed") {
            throw new InvalidTypeException("Property '{$this->propertyName}' must be setted to 'mixed' in order to convert values to boolean, or disable the 'convertToBoolean' parameter.");
        }

        if ($value === true || $value === false) {
            return;
        }

        $this->evaluateBooleanValue($value);
    }


    private function evaluateBooleanValue(mixed $value): void
    {
        $key = $value;

        if ($this->getType($value) == 'string') {
            $key = mb_strtolower($value);
        }

        if (array_key_exists($key, self::ACCEPTED_VALUES) == false) {
            $this->throwValidationException("Invalid value ('$value') for property '{$this->propertyName}'.");
        }

        if ($this->convertToBoolean) {
            $this->setValue(self::ACCEPTED_VALUES[$key]);
        }
    }
}
