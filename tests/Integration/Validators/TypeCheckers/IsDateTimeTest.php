<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\TypeCheckers\Contracts\InvalidIsDateTimeContract;
use Tests\Integration\Validators\TypeCheckers\Contracts\ValidIsDateTimeContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("TypeCheckers")]
#[Group("IsDateTime")]
#[TestDox("IsDateTime Validator")]
class IsDateTimeTest extends TestCase
{
    private ValidIsDateTimeContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsDateTimeContract;
    }


    #[TestDox("Should validate Date/Time strings")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should convert a string date/time to PHP DateTime object")]
    public function testShouldtoDateTime()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertTrue(is_a($this->stub->dt3, "DateTime"));
    }


    #[TestDox("Should throw ValidationException when date/time string doesn't match the expected format")]
    public function testShouldThrowWhenDateTimeStringDoesNotMatchFormat()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The Date/Time '13/03/1983' on 'dt2' is not valid or doesn't match to the format 'm/d/Y'.");
        $this->stub->dt2 = "13/03/1983";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when date/time string is not a date time")]
    public function testShouldThrowWhenDateTimeStringIsInvalid()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The Date/Time 'Not a date/time string' on 'dt1' is not valid or doesn't match to the format 'Y-m-d H:i:s'.");
        $this->stub->dt1 = "Not a date/time string";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when receives a non string value")]
    public function testShouldThrowWhenNonStringReceived()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'dt3' should receive a date/time string, received 'int'.");
        $this->stub->dt3 = 2024;
        $this->stub->validate();
    }


    #[TestDox("Shoudl throw ValidationException with a custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid Date/Time String!!!!");
        $this->stub->dt4 = ["06", "20", "2024"];
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when convertion is enabled and property type is not 'mixed'")]
    public function testShouldThrowWhenConvertionIsEnableAndPropertyTypeIsNotMixed()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'dt1' must be setted to 'mixed' in order to convert do DateTime object.");
        $stub = new InvalidIsDateTimeContract();
        $stub->validate();
    }
}
