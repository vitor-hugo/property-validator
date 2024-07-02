<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Numbers;

use InValidRangeContract;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;
use ValidRangeContract;

require_once __DIR__ . "/Contracts/RangeContract.php";

#[Group("Validators")]
#[Group("Numbers")]
#[Group("Range")]
#[TestDox("Range Number Validator")]
class RangeTest extends TestCase
{
    private ValidRangeContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidRangeContract();
    }


    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when LESSER THAN range")]
    public function testShouldThrowWhenLesserThanRange()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Value 1.98 on 'price' must be between 1.99 and 12.99.");
        $this->stub->price = 1.98;
        $this->stub->validate();
    }

    #[TestDox("Should throw ValidationException when GREATER THAN range")]
    public function testShouldThrowWhenGreaterThanRange()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Value 101 on 'percent' must be between 0 and 100.");
        $this->stub->percent = 101;
        $this->stub->validate();
    }


    #[TestDox("Should validate numeric strings")]
    public function testShouldValidateNumericStrings()
    {
        $this->stub->percent = "34.5";
        $this->stub->price = "2.45";
        $this->stub->swap = "9.99";
        $this->stub->custom = "-49";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException on non numeric strings")]
    public function testShouldThrowOnNonNumericStrings()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("'USD 8.99' on 'price' is not a valid numeric value.");
        $this->stub->price = "USD 8.99";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Not in range!");
        $this->stub->custom = "-51";
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException invalid value type")]
    public function testShouldThrowOnInvalidTypes()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'price' must receive int, float or string values, received array.");
        $this->stub->price = ["8.99"];
        $this->stub->validate();
    }
}
