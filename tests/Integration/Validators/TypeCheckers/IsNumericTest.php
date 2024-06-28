<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\TypeCheckers\Contracts\InvalidIsNumericContract;
use Tests\Integration\Validators\TypeCheckers\Contracts\ValidIsNumericContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("TypeCheckers")]
#[Group("IsNumeric")]
#[TestDox("IsNumeric Validator")]
class IsNumericTest extends TestCase
{
    private ValidIsNumericContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsNumericContract;
    }


    #[TestDox("Numeric values should be valid")]
    public function testShouldBeValid()
    {
        $this->stub->num1 = 2048;
        $this->stub->num2 = 3.1415;
        $this->stub->num3 = "1,999.99";
        $this->stub->num4 = "1983";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when value is not a number")]
    public function testShouldThrowWhenValueIsNotANumber()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("'USD 9.99' on 'num3' is not a valid numeric value.");
        $this->stub->num3 = "USD 9.99";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when value's type is not valid")]
    public function testShouldThrowWhenValueTypeIsNotValid()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num3' must receive values of type float, int or numeric string, received 'array'.");
        $this->stub->num3 = [2017];
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with a custom message")]
    public function testShouldThroWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Not a number!!!");
        $this->stub->num4 = ["array"];
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when the property\'s type is not mixed")]
    public function testShouldThrowInvalidTypeExceptionWhenPropertyTypeIsNotMixed()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'num1' must be setted as mixed.");
        $stub = new InvalidIsNumericContract;
        $stub->validate();
    }
}
