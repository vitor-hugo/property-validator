<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\TypeCheckers;

use Attribute;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;

/**
 * Validates whether the property value is a valid date time string
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class IsDateTime extends Validator
{
    /**
     * @param string $format Valid PHP `DateTime::format`, default is `'Y-m-d H:i:s'`. [(documentation)](https://www.php.net/manual/en/datetime.format.php)
     * @param mixed $convertToDateTimeObject Converts a date/time string to PHP DateTime object (default: `false`). If `true` the property type must be setted to `mixed`.
     * @param string|null $errorMessage Message to be displayed in case of validation error.
     */
    public function __construct(
        private string $format = "Y-m-d H:i:s",
        private $convertToDateTimeObject = false,
        string|null $errorMessage = null
    ) {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        $this->expectPropertyTypeToBe(["string", "mixed"]);
        $this->validateReceivedValue($value);

        if ($this->convertToDateTimeObject && $this->propertyType !== "mixed") {
            throw new InvalidTypeException("Property '{$this->propertyName}' must be setted to 'mixed' in order to convert do DateTime object.");
        }

        $dateTime = $this->validateDateTimeString($value);

        if ($this->convertToDateTimeObject) {
            $this->setValue($dateTime);
        }
    }


    private function validateReceivedValue(mixed $value): void
    {
        $type = $this->getType($value);
        if ($type !== "string") {
            $this->throwValidationException("Property '{$this->propertyName}' should receive a date/time string, '$type' received.");
        }
    }


    private function validateDateTimeString(string $dateTimeString): \DateTime
    {
        $dt = \DateTime::createFromFormat($this->format, $dateTimeString);

        if ($dt == false || $dt->format($this->format) !== $dateTimeString) {
            $this->throwValidationException("The Date/Time '{$dateTimeString}' on '{$this->propertyName}' is not valid or doesn't match to the format '{$this->format}'.", 1);
        }

        return $dt;
    }
}
