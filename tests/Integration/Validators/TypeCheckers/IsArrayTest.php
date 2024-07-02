<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\TypeCheckers\Contracts\ValidIsArrayContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("TypeCheckers")]
#[Group("IsArray")]
#[TestDox("IsArray Validator")]
class IsArrayTest extends TestCase
{
    private ValidIsArrayContract $stub;


    public function setUp(): void
    {
        $this->stub = new ValidIsArrayContract;
    }


    #[TestDox("Array values should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw InvalidTypeException when value is not an array")]
    public function testShouldThrowWhenNotAString()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'arr3' must receive array values, received float.");
        $this->stub->arr3 = 3.1415;
        $this->stub->validate();
    }


    #[TestDox("Should be valid when optional array is EMPTY")]
    public function testShouldBeValidWhenOptionalIsEmpty()
    {
        $this->stub->arr2 = [];
        $this->stub->validate();
        $this->assertEquals([], $this->stub->arr2);
    }


    #[TestDox("Should throw InvalidTypeException with custom error message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("This is not an array!");
        $this->stub->arr4 = 1000;
        $this->stub->validate();
    }
}
