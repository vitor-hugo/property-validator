<?php declare(strict_types=1);

namespace Torugo\PropertyValidator;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use Torugo\PropertyValidator\Interfaces\TransformerInterface;
use Torugo\PropertyValidator\Interfaces\ValidatorInterface;

class PropertyValidator
{
    /**
     * Validates and Transforms the properties of a class
     * @param object $class Instance of the class being validated
     * @return void
     */
    public static function validate(object $class): void
    {
        $properties = self::getProperties($class);

        foreach ($properties as $property) {
            if ($property->isInitialized($class) == false) {
                continue;
            }

            self::resolve($property, $class);
        }
    }


    /**
     * Gets an array of ReflectionProperty objects
     * @param object $class Class to be validated
     * @return array Array of ReflectionProperty
     */
    private static function getProperties(object $class): array
    {
        $reflectionClass = new ReflectionClass($class);
        $properties = $reflectionClass->getProperties();
        return $properties ?? [];
    }


    /**
     * Executes Validators and Transformers attributes in the order in which they were defined
     * @param \ReflectionProperty $property
     * @param object $class
     * @return void
     */
    private static function resolve(ReflectionProperty $property, object $class): void
    {
        $attributes = $property->getAttributes(null, ReflectionAttribute::IS_INSTANCEOF);

        foreach ($attributes as $attribute) {
            $instance = $attribute->newInstance();

            if ($instance instanceof ValidatorInterface) {
                $instance->validate($property, $class);
            } else if ($instance instanceof TransformerInterface) {
                $instance->transform($property, $class);
            }
        }
    }
}
