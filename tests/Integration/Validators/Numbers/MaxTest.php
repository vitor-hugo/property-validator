<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Numbers;

use InvalidMaxContract;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use ValidMaxContract;

require_once __DIR__ . "/Contracts/MaxContract.php";

#[Group("Validators")]
#[Group("Numbers")]
#[Group("Max")]
#[TestDox("Max Number Validator")]
class MaxTest extends TestCase
{

    private ValidMaxContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidMaxContract();
    }


    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when INT is greater than MAX")]
    public function testShouldThrowWhenIntIsGreaterThanMax()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num1' only accepts numbers up to 20, received 34.");
        $this->stub->num1 = 34;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when FLOAT is greater than MAX")]
    public function testShouldThrowWhenFloatIsGreaterThanMax()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num2' only accepts numbers up to 19.99, received 21.32.");
        $this->stub->num2 = 21.32;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when value's type is invalid")]
    public function testShouldThrowWhenReceiveAnInvalidValueType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num3' must receive float or int values, received string.");
        $this->stub->num3 = "3000";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom error message")]
    public function testShouldThrowWhenCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The number can't be greater than 100.");
        $this->stub->num4 = 101;
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when property's type is invalid")]
    public function testShouldThrowWhenPropertyTypeIsInvalid()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'ammount' must be setted as int, float or mixed.");
        $stub = new InvalidMaxContract();
        $stub->validate();
    }
}
