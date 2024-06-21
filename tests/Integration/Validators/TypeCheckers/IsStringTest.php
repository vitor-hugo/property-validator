<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\TypeCheckers\Contracts\ValidIsStringContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("TypeCheckers")]
#[Group("IsString")]
#[TestDox("IsString Validator")]
class IsStringTest extends TestCase
{
    private ValidIsStringContract $stub;


    public function setUp(): void
    {
        $this->stub = new ValidIsStringContract;
    }


    #[TestDox("String values should be valid")]
    public function testShouldBeValid()
    {
        $this->stub->validate();
        $this->assertEquals("Cecília Meireles", $this->stub->str1);
        $this->assertEquals("Optional String", $this->stub->str2);
        $this->assertEquals("Mixed Type", $this->stub->str3);
        $this->assertEquals("This is a string", $this->stub->str4);
    }


    #[TestDox("Should throw ValidationException when value is not a string")]
    public function testShouldThrowWhenNotAString()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'str3' must receive a string, received array.");
        $this->stub->str3 = ["array"];
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when required string is empty")]
    public function testShouldThrowWhenRequiredIsEmpty()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The property 'str1' can't be empty.");
        $this->stub->str1 = "";
        $this->stub->validate();
    }


    #[TestDox("Should be valid when optional string is EMPTY")]
    public function testShouldBeValidWhenOptionalIsEmpty()
    {
        $this->stub->str2 = '';
        $this->stub->validate();
        $this->assertEmpty($this->stub->str2);
    }


    #[TestDox("Should be valid when optional string is NULL")]
    public function testShouldBeValidWhenOptionalIsNull()
    {
        $this->stub->str2 = null;
        $this->stub->validate();
        $this->assertNull($this->stub->str2);
    }


    #[TestDox("Should throw ValidationException with custom error message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Not a String!!!");
        $this->stub->str4 = 1000;
        $this->stub->validate();
    }
}
