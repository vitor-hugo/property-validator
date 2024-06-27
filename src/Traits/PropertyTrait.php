<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Traits;

use Exception;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsOptional;
use Torugo\PropertyValidator\Attributes\Validators\Common\IsRequired;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;

trait PropertyTrait
{
    use TypeTrait;

    protected \ReflectionProperty $property;

    /** The class that property belongs to */
    protected object $class;

    /** The name of the property */
    protected string $propertyName;

    /** The type of the property, if not declared it will be considered 'mixed' */
    protected string $propertyType;

    /** The type of the property, if not declared it will be considered 'mixed' */
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
     * Checks wheter a property is defined as Optional
     *
     * A property can be defined as optional in two ways:
     * - Using the attribute `#[IsOptional()]`.
     * - Setting a property type as nullable. E.g. `protected ?string $name` or `protected mixed $name`
     * Otherwise the property will be considered required.
     *
     * @return bool
     */
    protected function isOptional(): bool
    {
        $this->checkIfIsInitialized();

        if ($this->isUsingIsOptionalAttribute()) {
            return true;
        }

        if ($this->isNullable()) {
            return true;
        }

        return false;
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
     * Checks wheter a property is defined as Required
     *
     * A property can be defined as required in two ways:
     * - Using the attribute `#[IsRequired()]`.
     * - Not setting a property type as nullable. E.g. `protected string $name`
     *
     * Properties type 'mixed' or nullable are considered optional.
     *
     * @return bool
     */
    protected function isRequired(): bool
    {
        $this->checkIfIsInitialized();

        if ($this->isUsingRequiredAttribute()) {
            return true;
        }

        if ($this->isNullable() == false) {
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
            throw new InvalidTypeException($this->buildInvalidTypeErrorMessage($expected));
        }
    }


    private function buildInvalidTypeErrorMessage(array|string $types): string
    {
        if ($this->getType($types) === "array") {
            $interp = implode(", ", $types);
            $interp = strrev(implode(strrev(" or"), explode(strrev(","), strrev($interp), 2)));
        } else {
            $interp = $types;
        }

        return "Property '{$this->propertyName}' must be setted as $interp.";
    }
}
