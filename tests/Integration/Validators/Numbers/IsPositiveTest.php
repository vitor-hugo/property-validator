<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Numbers;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

require_once __DIR__ . "/Contracts/IsPositiveContract.php";

#[Group("Validators")]
#[Group("Numbers")]
#[Group("IsPositive")]
#[TestDox("IsPositive Number Validator")]
class IsPositiveTest extends TestCase
{
    private \ValidIsPositiveContract $stub;


    public function setUp(): void
    {
        $this->stub = new \ValidIsPositiveContract();
    }


    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when value is equal to zero")]
    public function testShouldThrowWhenValueIsZero()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num1' only accepts positive numbers, received 0.");
        $this->stub->num1 = 0;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when INT is negative")]
    public function testShouldThrowWhenIntIsNegative()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num1' only accepts positive numbers, received -1.");
        $this->stub->num1 = -1;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when FLOAT is negative")]
    public function testShouldThrowWhenFloatIsNegative()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num2' only accepts positive numbers, received -0.001.");
        $this->stub->num2 = -0.001;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when value's type is invalid")]
    public function testShouldThrowWhenReceiveAnInvalidValueType()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num3' must receive float or int values, received string.");
        $this->stub->num3 = "500";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom error message")]
    public function testShouldThrowWhenCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Don't be so negative!");
        $this->stub->num4 = -200;
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when property's type is invalid")]
    public function testShouldThrowWhenPropertyTypeIsInvalid()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'ammount' must be setted as int, float or mixed.");
        $stub = new \InvalidIsPositiveContract();
        $stub->validate();
    }
}
