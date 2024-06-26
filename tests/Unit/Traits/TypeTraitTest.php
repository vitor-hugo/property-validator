<?php declare(strict_types=1);

namespace Tests\Unit\Traits;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Torugo\PropertyValidator\Traits\TypeTrait;

#[Group("Traits")]
#[Group("TypeTrait")]
#[TestDox("TypeTrait tests")]
class TypeTraitTest extends TestCase
{
    use TypeTrait;

    private array $arrayProp = [];
    private bool $booleanProp = true;
    private float $floatProp = 3.1415;
    private int $intProp = 2048;
    private mixed $mixedProp = "xyz";
    private null $nullProp = null;
    private object $objectProp;
    private string $stringProp = "string";

    #[TestDox("Method getType() must return the corret type")]
    public function testTypeTraitGetType()
    {
        $expects = [
            'array',
            'bool',
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


    #[TestDox("Method normalizeTypeName() must normalize type names correctly")]
    public function testNormalizeTypeName()
    {
        $expects = [
            'array',
            'bool',
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


    #[TestDox("Method getPropertyType() must return the corret type")]
    public function testGetPropertyType()
    {
        $this->objectProp = new class {};

        $propertiesToTest = [
            'arrayProp' => 'array',
            'booleanProp' => 'bool',
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


    #[TestDox("Method isValueEmtpy() must return if a value is empty")]
    public function testIsValueEmpty()
    {
        $this->assertTrue($this->isValueEmpty(""));
        $this->assertTrue($this->isValueEmpty([]));
        $this->assertTrue($this->isValueEmpty(null));
        $this->assertFalse($this->isValueEmpty(false));
        $this->assertFalse($this->isValueEmpty(0));
    }


    #[TestDox("Method expectValueTypeToBe() must return if a type is valid")]
    public function testIsTypeValid()
    {
        $type = "float";
        $types = ["string", "int", "array"];

        $this->assertTrue($this->isTypeValid("float", $type));
        $this->assertTrue($this->isTypeValid("string", $types));
        $this->assertTrue($this->isTypeValid("int", $types));
        $this->assertTrue($this->isTypeValid("array", $types));

        $this->assertFalse($this->isTypeValid("int", $type));
        $this->assertFalse($this->isTypeValid("bool", $types));
    }
}
