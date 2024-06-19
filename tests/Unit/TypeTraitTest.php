<?php declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Torugo\PropertyValidator\Traits\TypeTrait;

class TypeTraitTest extends TestCase
{
    use TypeTrait;

    private array $arrayProp = [];
    private bool $booleanProp = true;
    private float $floatProp = 3.1415;
    private int $intProp = 2048;
    private mixed $mixedProp = 'xyz';
    private null $nullProp = null;
    private object $objectProp;
    private string $stringProp = 'string';

    #[TestDox('TypeTrait: getType() must return the corret type')]
    public function testTypeTraitGetType()
    {
        $expects = [
            'array',
            'boolean',
            'float',
            'int',
            'null',
            'object',
            'string'
        ];

        $values = [
            ['array'],
            true,
            3.14145,
            2048,
            null,
            new class {},
            'string'
        ];

        foreach ($values as $index => $value) {
            $this->assertEquals($expects[$index], $this->getType($value));
        }
    }


    #[TestDox('TypeTrait: normalizeTypeName() must normalize type names correctly')]
    public function testNormalizeTypeName()
    {
        $expects = [
            'array',
            'boolean',
            'float',
            'float',
            'int',
            'int',
            'mixed',
            'null',
            'object',
            'string',
            'unknown',
        ];

        $types = [
            'ARRAY',
            'BOOLEAN',
            'DOUBLE',
            'FLOAT',
            'INT',
            'INTEGER',
            'MIXED',
            'NULL',
            'OBJECT',
            'STRING',
            'xyz',
        ];

        foreach ($types as $index => $type) {
            $this->assertEquals($expects[$index], $this->normalizeTypeName($type));
        }
    }

    #[TestDox('TypeTrait: getPropertyType() must return the corret type')]
    public function testGetPropertyType()
    {
        $this->objectProp = new class {};

        $propertiesToTest = [
            'arrayProp' => 'array',
            'booleanProp' => 'boolean',
            'floatProp' => 'float',
            'intProp' => 'int',
            'mixedProp' => 'mixed',
            'nullProp' => 'null',
            'objectProp' => 'object',
            'stringProp' => 'string',
        ];

        $reflectionClass = new \ReflectionClass($this);
        $classProperties = $reflectionClass->getProperties();

        foreach ($classProperties as $property) {
            $propName = $property->getName();
            if (array_key_exists($propName, $propertiesToTest)) {
                $this->assertEquals($propertiesToTest[$propName], $this->getPropertyType($property));
            }
        }
    }
}
