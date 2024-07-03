<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Abstract;

use ReflectionProperty;
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
     *
     * @param \ReflectionProperty $property Property to be validated
     * @param object $class Class that property belongs to
     * @return void
     */
    public function validate(ReflectionProperty $property, object $class): void
    {
        $this->initProperty($property, $class);
        $this->validateConflictingAttributes();

        if ($this->isValidationNecessary()) {
            $this->validation($this->propertyValue);
        }
    }


    /**
     * Conflicting attributes are those that cannot
     * be used side by side in a property.
     *
     * @throws \Torugo\PropertyValidator\Exceptions\ValidationException
     * @return void
     */
    private function validateConflictingAttributes()
    {
        $optional = $this->isUsingIsOptionalAttribute();
        $required = $this->isUsingRequiredAttribute();

        if ($optional && $required) {
            throw new ValidationException("Conflict: Property '{$this->propertyName}' can't use 'IsOptional' and 'IsRequired' side by side.");
        }
    }


    /**
     * Indicates wheter the validator execution is necessary
     *
     * @return bool
     */
    private function isValidationNecessary(): bool
    {
        return $this->isOptionalAttributeValidation();
    }


    /**
     * IsOptional is a special attribute, its executed before any other validator.
     * That's why the IsOptional class has no validation method.
     *
     * @return bool
     */
    private function isOptionalAttributeValidation(): bool
    {
        // property setted as optional
        $isOptional = $this->isUsingIsOptionalAttribute();

        // protety setted as mixed or nullable (?string, ?int, ?array ...)
        $isNullable = $this->isNullable();

        // A optional filed must be nullable
        if ($isOptional && $isNullable === false) {
            $this->throwInvalidTypeException("Property '{$this->propertyName}' must be nullable.");
        }

        // When not using isOptional, the properties are treated as NOT NULL
        if (!$isOptional && $this->propertyValue === null) {
            $this->throwValidationException("Property '{$this->propertyName}' can't be null.");
        }

        // If a property is optional, nullable and its value is empty/null
        // no validation needed
        if ($isOptional && $isNullable && $this->isValueEmpty($this->propertyValue)) {
            return false;
        }

        return true;
    }
}
