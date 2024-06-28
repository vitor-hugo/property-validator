<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidLengthContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Strings")]
#[Group("Length")]
#[TestDox("Length")]
class LengthTest extends TestCase
{
    private ValidLengthContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidLengthContract;
    }


    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should be valid when length is equal to min arg")]
    public function testShouldBeValidWhenLengthEqualToMinArg()
    {
        $this->stub->str1 = "044f234932";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should be valid when length is equal to max arg")]
    public function testShouldBeValidWhenLengthEqualToMaxArg()
    {
        $this->stub->str1 = "78abb844cda9388c351f";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when length is less than min arg")]
    public function testShouldThrowValidationExceptionOnMinArg()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The length of 'str1' must be at least 10 and at most 20.");
        $this->stub->str1 = "da9388";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when length is bigger than max arg")]
    public function testShouldThrowValidationExceptionOnMaxArg()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The length of 'str1' must be at least 10 and at most 20.");
        $this->stub->str1 = "431ed6851a456cf86c37e";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when length is bigger than max arg")]
    public function testShouldThrowValidationExceptionWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid password length.");
        $this->stub->password = "a91e3e";
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
