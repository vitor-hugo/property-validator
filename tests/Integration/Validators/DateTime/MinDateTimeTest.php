<?php declare(strict_types=1);

namespace Tests\Integration\Validators\DateTime;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\DateTime\Contracts\InvalidMinDateTimeContract;
use Tests\Integration\Validators\DateTime\Contracts\ValidMinDateTimeContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("DateTime")]
#[Group("MinDateTime")]
#[TestDox("MinDateTime Validator")]
class MinDateTimeTest extends TestCase
{
    private ValidMinDateTimeContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidMinDateTimeContract;
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


    #[TestDox("Should throw ValidationException when date is before the date limit")]
    public function testThrowWhenDateTimeExceedsTheDateLimit()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The date/time value of 'date' is before the minimum acceptable date/time.");
        $this->stub->date = new \DateTime("now -1 day");
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when time is before the time limit")]
    public function testThrowWhenDateTimeExceedsTheTimeLimit()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The date/time value of 'time' is before the minimum acceptable date/time.");
        $this->stub->time = new \DateTime("now -1 second");
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
        $stub = new InvalidMinDateTimeContract;
        $stub->validate();
    }
}
