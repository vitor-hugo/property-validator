<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Arrays\Contracts\ValidArrayNotContainsContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Arrays")]
#[Group("ArrayNotContains")]
#[TestDox("ArrayNotContains(): validator")]
class ArrayNotContainsTest extends TestCase
{
    public ValidArrayNotContainsContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidArrayNotContainsContract;
    }


    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when value not found (1)")]
    public function testShouldThrowWhenNotFound1()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'arr1' cannot contains string('pineapple').");
        $this->stub->arr1 = ["apple", "pineapple", "grapes", "orange"];
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when value found (2)")]
    public function testShouldThrowWhenNotFound2()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'arr5' cannot contains array([31, 41]).");
        $this->stub->arr5 = ["11", "21", ["31", "41"]];
        $this->stub->validate();
    }


    #[TestDox("Should be valid when string not found because case sensitiveness")]
    public function testShouldBeValidWhenStringNotFoundBecauseCaseSensitiveness()
    {
        $this->stub->arr1 = ["Apple", "Pineapple", "Grapes", "Orange"];
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when strictType is disabled")]
    public function testShouldThrowWhenStringType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'arr3' cannot contains int(50).");
        $this->stub->arr3 = ["50"];
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when value is not an array")]
    public function testShouldThrowWhenNotArray()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'arr1' must receive array values, received string.");
        $this->stub->arr1 = "not an array";
        $this->stub->validate();
    }

    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Alergic to pineappe!!!");
        $this->stub->arr6 = ["pineapple"];
        $this->stub->validate();
    }
}
