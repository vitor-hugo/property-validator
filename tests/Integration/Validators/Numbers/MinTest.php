<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Numbers;

use InvalidMinContract;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use ValidMinContract;

require_once __DIR__ . "/Contracts/MinContract.php";

#[Group("Validators")]
#[Group("Numbers")]
#[Group("Min")]
#[TestDox("Min Number Validator")]
class MinTest extends TestCase
{

    private ValidMinContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidMinContract();
    }


    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when INT is lesser than MIN")]
    public function testShouldThrowWhenIntIsGreaterThanMin()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num1' only accepts numbers greater than or equal to 0, received -19.");
        $this->stub->num1 = -19;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when FLOAT is lesser than MIN")]
    public function testShouldThrowWhenFloatIsGreaterThanMin()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num2' only accepts numbers greater than or equal to 19.99, received 11.99.");
        $this->stub->num2 = 11.99;
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when value's type is invalid")]
    public function testShouldThrowWhenReceiveAnInvalidValueType()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'num3' must receive int or float values, received string.");
        $this->stub->num3 = "3000";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom error message")]
    public function testShouldThrowWhenCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The number can't be lesser than 80.");
        $this->stub->num4 = 74;
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when property's type is invalid")]
    public function testShouldThrowWhenPropertyTypeIsInvalid()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'ammount' must be setted as int, float or mixed.");
        $stub = new InvalidMinContract();
        $stub->validate();
    }
}
