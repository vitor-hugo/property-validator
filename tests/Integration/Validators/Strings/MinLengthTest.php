<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidMinLengthContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Strings")]
#[Group("MinLength")]
#[TestDox("MinLength")]
class MinLengthTest extends TestCase
{
    private ValidMinLengthContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidMinLengthContract;
    }


    #[TestDox("Should be valid when length is bigger than min arg")]
    public function testShouldBeValid()
    {
        $x = "asdfasd";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should be valid when length is equal to min arg")]
    public function testShouldBeValidWhenLengthEqualToMaxArg()
    {
        $this->stub->str1 = "c8bb28cc2e";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when length is lesser than min arg")]
    public function testShouldThrowValidationExceptionOnMaxArg()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The length of 'str1' must be at least 10, 8 received.");
        $this->stub->str1 = "75bc24b5";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowValidationExceptionWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Very few characters!");
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
