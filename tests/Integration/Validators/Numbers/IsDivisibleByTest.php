<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Numbers;

use InvalidIsDivisibleByContract;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use ValidIsDivisibleByContract;

require_once __DIR__ . "/Contracts/IsDivisibleByContract.php";

#[Group("Validators")]
#[Group("Numbers")]
#[Group("IsDivisibleBy")]
#[TestDox("IsDivisibleBy Number Validator")]
class IsDivisibleByTest extends TestCase
{
    private ValidIsDivisibleByContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsDivisibleByContract();
    }


    #[TestDox("All values should be divisible by defined numbers")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when the value is not divisible by defined number")]
    public function testShouldThrowWhenValueIsNotDivisible()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The number 9 on property 'num1', is not divisible by 2.");

        $this->stub->num1 = 9;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when value type is invalid")]
    public function testShouldThrowWhenReceiveInvalidValueType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num3' must receive float or int values, received string.");

        $this->stub->num3 = "13.8";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Not divisible by 2");

        $this->stub->num4 = 7;
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when property's type is invalid")]
    public function testShouldThrowWhenPropertyTypeIsInvalid()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'number' must be setted as int, float or mixed.");
        $stub = new InvalidIsDivisibleByContract();
        $stub->validate();
    }
}
