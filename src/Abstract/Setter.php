<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Abstract;

use ReflectionProperty;
use Torugo\PropertyValidator\Interfaces\SetterInterface;
use Torugo\PropertyValidator\Traits\PropertyTrait;

abstract class Setter implements SetterInterface
{
    use PropertyTrait;

    /**
     * Performs property value setter
     *
     * @throws \Torugo\PropertyValidator\Exceptions\ValidationException
     * @return void
     */
    public abstract function setter(): void;


    /**
     * Executes the property filler
     *
     * @param \ReflectionProperty $property Property to be manipulated
     * @param object $class Class that property belongs to
     * @return void
     */
    public function set(ReflectionProperty $property, object $class): void
    {
        $this->initProperty($property, $class);
        $this->setter();
    }


    /**
     * Validates if the property type is the expected.
     *
     * @param array|string $expected array of type names or a single string type name
     * @return bool
     */
    protected function propertTypeIs(array|string $expected): bool
    {
        return $this->isTypeValid($this->propertyType, $expected);
    }


    /**
     * Validates if the value type is the expected.
     *
     * @param array|string $expected array of type names or a single string type name
     * @return bool
     */
    protected function valueTypeIs(array|string $expected): bool
    {
        $propType = $this->getType($this->propertyValue);
        return $this->isTypeValid($propType, $expected);
    }
}
