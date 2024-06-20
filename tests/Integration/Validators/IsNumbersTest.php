<?php declare(strict_types=1);

namespace Tests\Integration\Validators;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Contracts\ValidIsNumberContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("TypeCheckers")]
#[Group("IsNumber")]
#[TestDox("IsNumber Validator")]
class IsNumbersTest extends TestCase
{
    private ValidIsNumberContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsNumberContract;
    }


    #[TestDox("Number values should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when value is not a number")]
    public function testShouldThrowWhenValueIsNotANumber()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'num3' must receive integer or float values, string received.");
        $this->stub->num3 = "2017";
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
}
