<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidMaxLengthContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Strings")]
#[Group("MaxLength")]
#[TestDox("MaxLength")]
class MaxLengthTest extends TestCase
{
    private ValidMaxLengthContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidMaxLengthContract;
    }


    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should be valid when length is equal to max arg")]
    public function testShouldBeValidWhenLengthEqualToMaxArg()
    {
        $this->stub->str1 = "078316a4d484501d7c41c2c581bdd6";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when length is bigger than max arg")]
    public function testShouldThrowValidationExceptionOnMaxArg()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("MaxLength: The length of 'str1' can be at most 30, 32 received.");
        $this->stub->str1 = "2b6e36c2931b1d1103ff505fd139a2ac";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowValidationExceptionWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Exceeded Max Length!");
        $this->stub->str2 = "ed1a5ef09d3de41a1f";
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when value's type is not string")]
    public function testShouldThrowInvalidTypeExceptionOnInvalidValueType()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("The value type of 'str1' must be setted as string, array received.");
        $this->stub->str1 = ["array"];
        $this->stub->validate();
    }
}
