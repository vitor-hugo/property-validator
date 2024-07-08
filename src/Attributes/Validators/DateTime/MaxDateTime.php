<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Attributes\Validators\DateTime;

use Attribute;
use DateTimeZone;
use Torugo\PropertyValidator\Abstract\Validator;
use Torugo\PropertyValidator\Attributes\Validators\TypeCheckers\IsDateTime;

/**
 * Validates whether a DateTime instance is greater than a defined limit.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class MaxDateTime extends Validator
{
    /**
     * @param \DateTime $max Maximum acceptable Date/Time.
     * @param string|null $errorMessage Custom error message.
     */
    public function __construct(private \DateTime $max, string|null $errorMessage = null)
    {
        parent::__construct($errorMessage);
    }


    public function validation(mixed $value): void
    {
        $this->checkPropertyAndValueTypes($value);
        $this->checkDateTimeInterval($value);
    }


    private function checkPropertyAndValueTypes(mixed $dateTime): void
    {
        $propType = $this->getPropertyType($this->property);

        if ($propType !== "mixed" && $propType !== "DateTime") {
            $this->throwInvalidTypeException("Property '{$this->propertyName}' must be defined as 'mixed' or 'DateTime', but is declared as '$propType'.");
        }

        $valueType = $this->getType($dateTime);

        if ($valueType !== "object") {
            $this->throwInvalidTypeException("Value of '{$this->propertyName}' should be a DateTime instance, $valueType given.");
        }

        $instance = $this->getClassName($dateTime::class);
        if ($instance !== "DateTime") {
            $this->throwInvalidTypeException("Value of '{$this->propertyName}' should be a DateTime instance, $instance given.");
        }
    }


    private function checkDateTimeInterval(\DateTime $dt): void
    {
        $timezone = new DateTimeZone("UTC");
        $dt->setTimezone($timezone);
        $this->max->setTimezone($timezone);

        if ($dt->getTimestamp() > $this->max->getTimestamp()) {
            $this->throwValidationException("The date/time value of '{$this->propertyName}' exceeded the maximum date/time limit.");
        }
    }
}
