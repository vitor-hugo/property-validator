<?php declare(strict_types=1);

namespace Tests\Unit\Traits;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Traits\PropertyTrait;

#[Group("Traits")]
#[Group("PropertyTrait")]
#[TestDox("PropertyTrait tests")]
class PropertyTraitTest extends TestCase
{
    use PropertyTrait;

    private string $string = "My Name";
    private ?int $integer = 40;
    private mixed $mixed = ['array'];

    #[TestDox("Should throw Exception when the property was not initialized")]
    public function testShouldThrowExceptionWhenNotInitialized()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The property must be initialized before usage.");
        $this->getValue();
    }


    #[TestDox("Method getIsInitialized() should return FALSE when the property was not initialized")]
    public function testGetIsInitializedShouldReturnFalse()
    {
        $this->assertFalse($this->getIsInitialized());
    }


    #[TestDox("Method getIsInitialized() should return TRUE when the property is initialized")]
    public function testPropertyInitialization()
    {
        $property = new \ReflectionProperty($this, "string");
        $this->initProperty($property, $this);
        $this->assertTrue($this->getIsInitialized());
    }


    #[TestDox("Method getValue() should return the property's value")]
    public function testGetValueShouldReturnPropertyValue()
    {
        $property = new \ReflectionProperty($this, "string");
        $this->initProperty($property, $this);
        $this->assertEquals("My Name", $this->getValue());
    }


    #[TestDox("Method setValue() should update the property's value")]
    public function testSetValueShouldUpdatePropertyValue()
    {
        $property = new \ReflectionProperty($this, "string");
        $this->initProperty($property, $this);
        $this->setValue("My Full Name");
        $this->assertEquals("My Full Name", $this->getValue());
    }


    #[TestDox("Method isNullable() should return if a property can be NULL")]
    public function testIsNullableMethod()
    {
        $property = new \ReflectionProperty($this, "string");
        $this->initProperty($property, $this);
        $this->assertFalse($this->isNullable());

        $property = new \ReflectionProperty($this, "integer");
        $this->initProperty($property, $this);
        $this->assertTrue($this->isNullable());

        $property = new \ReflectionProperty($this, "mixed");
        $this->initProperty($property, $this);
        $this->assertTrue($this->isNullable());
    }


    #[TestDox("Method expectPropertyTypeToBe() should throw InvalidTypeException when property type is not the expected (array param)")]
    public function testExpectPropertyTypeToBeMethod1()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'string' must be setted as int, float or mixed.");
        $property = new \ReflectionProperty($this, "string");
        $this->initProperty($property, $this);
        $this->expectPropertyTypeToBe(["int", "float", "mixed"]);
    }


    #[TestDox("Method expectPropertyTypeToBe() should throw InvalidTypeException when property type is not the expected (string param)")]
    public function testExpectPropertyTypeToBeMethod2()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'mixed' must be setted as string.");
        $property = new \ReflectionProperty($this, "mixed");
        $this->initProperty($property, $this);
        $this->expectPropertyTypeToBe("string");
    }


    #[TestDox("Method expectPropertyValueTypeToBe() should throw InvalidTypeException when property type is not the expected (string param)")]
    public function testExpectValueTypeToBe()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("The value type of 'mixed' must be setted as int, float or string, array received.");
        $property = new \ReflectionProperty($this, "mixed");
        $this->initProperty($property, $this);
        $this->expectValueTypeToBe(["int", "float", "string"]);
    }


    #[TestDox("Method writeListOfTypes() should build a list of types separated by 'comma' and a final 'or'")]
    public function testBuildInvalidTypeErrorMessage()
    {
        $property = new \ReflectionProperty($this, "mixed");
        $this->initProperty($property, $this);

        $msg = $this->writeListOfTypes("array");
        $this->assertEquals("array", $msg);

        $msg = $this->writeListOfTypes(["int", "float", "string", "bool"]);
        $this->assertEquals("int, float, string or bool", $msg);
    }
}
