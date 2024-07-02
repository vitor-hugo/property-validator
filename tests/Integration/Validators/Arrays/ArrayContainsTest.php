<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Arrays\Contracts\ValidArrayContainsContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Arrays")]
#[Group("ArrayContains")]
#[TestDox("ArrayContains(): ValidIsOptionalContract")]
class ArrayContainsTest extends TestCase
{
    public ValidArrayContainsContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidArrayContainsContract;
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
        $this->expectExceptionMessage("Property 'arr1' does not contains string('banana').");
        $this->stub->arr1 = ["apple", "grapes", "orange"];
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when value not found (2)")]
    public function testShouldThrowWhenNotFound2()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'arr5' does not contains array([30, 40]).");
        $this->stub->arr5 = ["11", "21", ["31", "41"]];
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when strictType is enabled")]
    public function testShouldThrowWhenStringType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'arr2' does not contains int(20).");
        $this->stub->arr2 = [10, "20", 30, 40];
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
}
