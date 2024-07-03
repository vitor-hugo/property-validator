<?php declare(strict_types=1);

namespace Torugo\PropertyValidator\Abstract;

use ReflectionProperty;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Interfaces\HandlerInterface;
use Torugo\PropertyValidator\Traits\PropertyTrait;

abstract class Handler implements HandlerInterface
{
    use PropertyTrait;

    /**
     * Performs property value handler
     *
     * @throws \Torugo\PropertyValidator\Exceptions\ValidationException
     * @return void
     */
    public abstract function handler(mixed $value): void;


    /**
     * Executes the property value handler
     *
     * @param \ReflectionProperty $property Property to be manipulated
     * @param object $class Class that property belongs to
     * @return void
     */
    public function handle(ReflectionProperty $property, object $class): void
    {
        $this->initProperty($property, $class);
        $this->handler($this->propertyValue);
    }


    /**
     * Validates if the property type is the expected.
     * @param array|string $expected array of type names or a single string type name
     * @return void
     * @override
     */
    protected function expectValueTypeToBe(array|string $expected): void
    {
        if ($this->isTypeValid($this->getType($this->propertyValue), $expected) === false) {
            $types = $this->writeListOfTypes($expected, "and");
            $attr = $this->getClassName($this::class);
            throw new InvalidTypeException("$attr only handles $types values.");
        }
    }
}
