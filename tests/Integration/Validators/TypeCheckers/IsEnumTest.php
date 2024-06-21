<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers;

use NonexistentEnum;
use NotBackedEnum;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\TypeCheckers\Contracts\ValidIsEnumContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

require __DIR__ . "/Contracts/InvalidIsEnumContracts.php";

#[Group("Validators")]
#[Group("TypeCheckers")]
#[Group("IsEnum")]
#[TestDox("IsEnum Validator")]
class IsEnumTest extends TestCase
{
    private ValidIsEnumContract $stub;


    public function setUp(): void
    {
        $this->stub = new ValidIsEnumContract;
    }


    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when string value is not enum's member")]
    public function testShouldThrowWhenStringNotAMemberOfEnum()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The value 'X' on property 'var1' is not member of 'ValidStringEnum'.");
        $this->stub->var1 = "X";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when int value is not enum's member")]
    public function testShouldThrowWhenIntNotAMemberOfEnum()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The value '7' on property 'var2' is not member of 'ValidIntEnum'.");
        $this->stub->var2 = 7;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when value's type is not int or string")]
    public function testShouldThrowWhenValueTypeIsInvalid()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'var3' expects to receive a string or an int value, received array.");
        $this->stub->var3 = ["array"];
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with a custom error message")]
    public function testShouldThrowWhenWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid Database ID");
        $this->stub->var4 = 3.1415;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when enum do not exists")]
    public function testShouldThrowWhenEnumNotExists()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Enum 'Tests\Integration\XYZ' does not exists.");
        $stub = new NonexistentEnum();
        $stub->validate();
    }


    #[TestDox("Should throw ValidationException when enum is not backed")]
    public function testShouldThrowWhenEnumIsNotBacked()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Enum 'InvalidEnum' must be backed as 'string' or 'int'.");
        $stub = new NotBackedEnum();
        $stub->validate();
    }
}
