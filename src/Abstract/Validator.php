<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Abstract;

use ReflectionProperty;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use Torugo\PropertyValidator\Interfaces\ValidatorInterface;
use Torugo\PropertyValidator\Traits\PropertyTrait;

abstract class Validator implements ValidatorInterface
{
    use PropertyTrait;

    /** Indicates wheter a property is optional */
    protected bool $isOptional = false;

    /** Indicates wheter a property can be null */
    protected bool $isNullable = false;

    /**
     * Performs property value validation
     *
     * @throws \Torugo\PropertyValidator\Exceptions\ValidationException
     * @return void
     */
    public abstract function validation(mixed $value): void;

    /**
     * @param mixed $errorMessage Message to be displayed in case of validation error
     */
    public function __construct(private ?string $errorMessage = null)
    {
    }


    /**
     * Executes the property validation
     * @param \ReflectionProperty $property Property to be validated
     * @param object $class Class that property belongs to
     * @return void
     */
    public function validate(ReflectionProperty $property, object $class): void
    {
        $this->initProperty($property, $class);

        if ($this->isValidationNecessary()) {
            $this->validation($this->propertyValue);
        }
    }


    private function isValidationNecessary(): bool
    {
        $isOptional = $this->isOptional();
        $isNullable = $this->isNullable();
        $isUsingIsOptionalAttribute = $this->isUsingIsOptionalAttribute();
        $isUsingRequiredAttribute = $this->isUsingRequiredAttribute();
        $isEmpty = $this->isValueEmpty($this->getValue());

        // Optional properties must be nullable
        if ($isOptional == true && $isNullable == false) {
            throw new InvalidTypeException("The property '{$this->propertyName}' is defined as optional but is not nullable. Optional properties must be nullable.");
        }

        // Properties are considered required when not using IsOptional atrribute or it's type is not mixed and not nullable
        if (
            !$isUsingRequiredAttribute &&
            !$isUsingIsOptionalAttribute &&
            !$isNullable &&
            $isEmpty &&
            $this->propertyType !== 'mixed'
        ) {
            throw new ValidationException("The property '{$this->propertyName}' can't be empty.");
        }

        // If a property is optional or nullable and it's value is empty, no validation is necessary
        if (!$isUsingRequiredAttribute && ($isOptional || $isNullable) && $isEmpty) {
            return false;
        }

        return true;
    }
}
