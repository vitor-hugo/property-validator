<?php declare(strict_types=1);

namespace Tests\Integration\Validators\DateTime;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\DateTime\Contracts\InvalidMaxDateTimeContract;
use Tests\Integration\Validators\DateTime\Contracts\ValidMaxDateTimeContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("DateTime")]
#[Group("MaxDateTime")]
#[TestDox("Max DateTime Validator")]
class MaxDateTimeTest extends TestCase
{
    private ValidMaxDateTimeContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidMaxDateTimeContract;
    }

    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }

    #[TestDox("Should be valid when equals")]
    public function testShouldBeValidWhenEquals()
    {
        $this->stub->equals = new \DateTime("2017-08-01 12:30:45");
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when value exceeds the Date limit")]
    public function testThrowWhenDateTimeExceedsTheDateLimit()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The date/time value of 'date' exceeded the maximum date/time limit.");
        $this->stub->date = new \DateTime("now + 3 days");
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when value exceeds the Time limit")]
    public function testThrowWhenDateTimeExceedsTheTimeLimit()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The date/time value of 'time' exceeded the maximum date/time limit.");
        $this->stub->time = new \DateTime("now + 1 second");
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when value a DateTime instance. (1)")]
    public function testShouldThrowWhenValueIsNotADateTimeInstance1()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Value of 'time' should be a DateTime instance, string given.");
        $this->stub->time = "2017-08-01 12:30:45";
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when value a DateTime instance. (2)")]
    public function testShouldThrowWhenValueIsNotADateTimeInstance2()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Value of 'time' should be a DateTime instance, DateTimeZone given.");
        $this->stub->time = new \DateTimeZone("UTC");
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when property type is invalid")]
    public function testShouldThrowOnInvalidPropertyType()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'maxDate' must be defined as 'mixed' or 'DateTime', but is declared as 'string'.");
        $stub = new InvalidMaxDateTimeContract;
        $stub->validate();
    }
}
