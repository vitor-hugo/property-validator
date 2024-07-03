<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidMatchesContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('Matches')]
#[TestDox('Matches - String Validator')]
class MatchesTest extends TestCase
{
    private ValidMatchesContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidMatchesContract;
    }


    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when value not matches")]
    public function testShouldThrowWhenNotMatches()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The the value of 'color' is invalid.");
        $this->stub->color = "#ABCD";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Uppercase letters only!");
        $this->stub->name = "Leia Organa";
        $this->stub->validate();
    }


    #[TestDox("Should throw InvalidTypeException on non string values")]
    public function testShouldThrowOnNonStrings()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'color' must receive string values, received int.");
        $this->stub->color = 112233;
        $this->stub->validate();
    }
}
