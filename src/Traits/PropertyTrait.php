<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Traits;

use Exception;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsRequired;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

trait PropertyTrait
{
    use TypeTrait;

    protected \ReflectionProperty $property;

    /** The class that property belongs to */
    protected object $class;

    /** The name of the property */
    protected string $propertyName;

    /** The type of the property, if not declared it will be considered "mixed" */
    protected string $propertyType;

    /** The value of the property */
    protected mixed $propertyValue;

    /** Indicates if the property was initialized */
    private $isInitialized = false;


    public function getIsInitialized(): bool
    {
        return $this->isInitialized;
    }


    /**
     * @throws \Exception If the property was not initialized
     * @return void
     */
    private function checkIfIsInitialized(): void
    {
        if ($this->isInitialized == false) {
            throw new Exception("The property must be initialized before usage.");
        }
    }


    protected function initProperty(\ReflectionProperty $property, object $class): void
    {
        $this->property = $property;
        $this->class = $class;
        $this->propertyName = $property->getName();
        $this->propertyType = $this->getPropertyType($property);
        $this->isInitialized = true;
        $this->propertyValue = $this->getValue();
    }


    /**
     * Returns the property's value
     * @return mixed
     */
    protected function getValue(): mixed
    {
        $this->checkIfIsInitialized();

        return $this->property->getValue($this->class);
    }


    /**
     * Updates the property's value
     * @param mixed $value New value
     * @return void
     */
    protected function setValue(mixed $value): void
    {
        $this->checkIfIsInitialized();

        $this->property->setValue($this->class, $value);
        $this->propertyValue = $value;
    }


    /**
     * Checks wheter a property is nullable
     * @return bool
     */
    protected function isNullable(): bool
    {
        $this->checkIfIsInitialized();

        $propType = $this->property->getType();

        if ($propType == null) {
            return true;
        } else {
            return $propType->allowsNull();
        }
    }


    /**
     * Returns if the property is using the #[IsOptional()] attribute.
     * @return bool
     */
    protected function isUsingIsOptionalAttribute(): bool
    {
        if ($this->property->getAttributes(IsOptional::class, \ReflectionAttribute::IS_INSTANCEOF) != null) {
            return true;
        }

        return false;
    }


    /**
     * Checks if the property is using the #[IsRequried()] attribute.
     * @return bool
     */
    protected function isUsingRequiredAttribute(): bool
    {
        if ($this->property->getAttributes(IsRequired::class, \ReflectionAttribute::IS_INSTANCEOF) != null) {
            return true;
        }

        return false;
    }


    /**
     * Returns the object class name from a namespace
     * @param string $classNamespace
     * @return string
     */
    protected function getClassName(string $classNamespace): string
    {
        $arr = explode('\\', $classNamespace);
        if ($arr == false) {
            return "";
        }
        return end($arr);
    }


    /**
     * Validates if the property type is the expected.
     * @param array|string $expected array of type names or a single string type name
     * @return void
     */
    protected function expectPropertyTypeToBe(array|string $expected): void
    {
        if ($this->isTypeValid($this->propertyType, $expected) === false) {
            $types = $this->writeListOfTypes($expected);
            throw new InvalidTypeException("Property '{$this->propertyName}' must be setted as $types.");
        }
    }


    /**
     * Validates if the property value type is the expected.
     * @param array|string $expected array of type names or a single string type name
     * @return void
     */
    protected function expectPropertyValueToBe(array|string $expected): void
    {
        $valueType = $this->getType($this->propertyValue);

        if ($this->isTypeValid($valueType, $expected) === false) {
            $types = $this->writeListOfTypes($expected);
            $this->throwInvalidTypeException("Property '{$this->propertyName}' must receive $types values, received $valueType.");
        }
    }


    private function writeListOfTypes(array|string $types): string
    {
        if ($this->getType($types) === "array") {
            $interpolation = implode(", ", $types);
            $interpolation = strrev(implode(strrev(" or"), explode(strrev(","), strrev($interpolation), 2)));
        } else {
            $interpolation = $types;
        }

        return $interpolation;
    }


    /**
     * Throws ValidationException using the validator's default message or
     * the custom error message defined on constructor.
     * @param string $message Message to be thrown
     * @param int $code Optional error code
     * @throws \Torugo\PropertyValidator\Exceptions\ValidationException
     * @return never
     */
    public function throwValidationException(string $message, int $code = 0): never
    {
        if (empty($this->errorMessage)) {
            $message = "$message";
        } else {
            $message = $this->errorMessage;
        }

        $message = trim($message);
        $message .= preg_match("/.*[a-zA-Z0-9]$/", $message) ? "." : "";

        throw new ValidationException($message);
    }


    /**
     * Throws InvalidTypeException using the validator's default message or
     * the custom error message defined on constructor.
     * @param string $message Message to be thrown
     * @param int $code Optional error code
     * @throws \Torugo\PropertyValidator\Exceptions\ValidationException
     * @return never
     */
    public function throwInvalidTypeException(string $message, int $code = 0): never
    {
        if (empty($this->errorMessage)) {
            $message = "$message";
        } else {
            $message = $this->errorMessage;
        }

        // adds final period
        $message = trim($message);
        $message .= substr($message, -1) == "." ? "" : ".";

        throw new InvalidTypeException($message);
    }
}
