<?php declare(strict_types=1);

namespace Tests\Integration\Validators\TypeCheckers;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\TypeCheckers\Contracts\InvalidIsBooleanContract;
use Tests\Integration\Validators\TypeCheckers\Contracts\ValidIsBooleanContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("TypeCheckers")]
#[Group("IsBoolean")]
#[TestDox("IsBoolean Validator")]
class IsBooleanTest extends TestCase
{
    private ValidIsBooleanContract $stub;
    private const TRUE_VALUES = [true, 1, "1", "true", "ok", "yes", "y", "sim", "s"];
    private const FALSE_VALUES = [false, 0, "0", "false", "no", "not", "n", "não", "nao"];

    public function setUp(): void
    {
        $this->stub = new ValidIsBooleanContract;
    }


    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    public function testShouldEvaluateAsTrue()
    {
        foreach (self::TRUE_VALUES as $value) {
            $this->stub->var2 = $value;
            $this->assertTrue($this->stub->validate());
            $this->assertTrue($this->stub->var2 === true);
        }
    }


    public function testShouldEvaluateAsFalse()
    {
        foreach (self::FALSE_VALUES as $value) {
            $this->stub->var2 = $value;
            $this->assertTrue($this->stub->validate());
            $this->assertTrue($this->stub->var2 === false);
        }
    }


    public function testShouldConvertTrueValuesToBoolean()
    {
        foreach (self::TRUE_VALUES as $value) {
            $this->stub->var3 = $value;
            $this->assertTrue($this->stub->validate());
            $this->assertTrue($this->stub->var3 === $value);
        }
    }


    public function testShouldConvertFalseValuesToBoolean()
    {
        foreach (self::FALSE_VALUES as $value) {
            $this->stub->var3 = $value;
            $this->assertTrue($this->stub->validate());
            $this->assertTrue($this->stub->var3 === $value);
        }
    }


    public function testConvertionMustBeCaseInsensitive()
    {
        $values = [...self::TRUE_VALUES, ...self::FALSE_VALUES];

        foreach ($values as $value) {
            if (gettype($value) == "string") {
                $value = mb_strtoupper($value);
            }

            $this->stub->var2 = $value;
            $this->assertTrue($this->stub->validate());
            $this->assertIsBool($this->stub->var2);
            $this->assertTrue($this->stub->var2 === true || $this->stub->var2 === false);
        }
    }


    public function testConvertionMustNotChangeTheCaseOfOrigivalValue()
    {
        $values = [...self::TRUE_VALUES, ...self::FALSE_VALUES];

        foreach ($values as $value) {
            if (gettype($value) === "string") {
                $value = mb_strtoupper($value);
            }

            $this->stub->var3 = $value;
            $this->assertTrue($this->stub->validate());
            $this->assertTrue($this->stub->var3 === $value);
        }
    }


    #[TestDox("Should throw ValidationException when receiving an invalid boolean value")]
    public function testShouldThrowWhenReceiveInvalidBooleanValue()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid value ('corret') for property 'var2'.");
        $this->stub->var2 = "corret";
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException when convertion is enabled and property type is not 'mixed'")]
    public function testShouldThrowWhenConvertionIsEnabledAndPropertyTypeIsBool()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'var1' must be setted to 'mixed' in order to convert values to boolean, or disable the 'convertToBoolean' parameter.");
        $stub = new InvalidIsBooleanContract;
        $stub->validate();
    }
}
