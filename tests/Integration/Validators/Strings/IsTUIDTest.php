<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidIsTUIDContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Strings")]
#[Group("IsTUID")]
#[TestDox("IsTUID")]
class IsTUIDTest extends TestCase
{
    public ValidIsTUIDContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsTUIDContract();
    }


    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }

    #[TestDox("Should throw ValidationException on invalid string")]
    public function testShouldThrowOnInvalidStrings()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'short' is not valid.");
        $this->stub->short .= "X";
        $this->stub->validate();
    }

    #[TestDox("Should throw ValidationException with custom error message")]
    public function testShouldThrowWithCustomErrorMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid ID!");
        $this->stub->long .= "X";
        $this->stub->validate();
    }
}
