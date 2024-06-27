<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidNotContainsContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('NotContains')]
#[TestDox('NotContains - String Validator')]
class NotContainsTest extends TestCase
{
    public ValidNotContainsContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidNotContainsContract;
    }

    #[TestDox('Should be valid when the substring is not found')]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox('Should be valid when the substring is not found with case sensitiveness enabled')]
    public function testShouldBeValidWithCaseSensitivenessEnabled()
    {
        $this->stub->str1 = "BREAK A LEG";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox('Should throw ValidationException when the substring is found')]
    public function testShouldThrowWhenNotFound()
    {
        $this->expectException(ValidationException::class);
        $this->stub->str1 = "Break a leg";
        $this->stub->validate();
    }


    #[TestDox('Should throw ValidationException when the substring is found with case sensitiveness disabled')]
    public function testShouldThrowWhenNotFoundWithCaseSensitivenessDisabled()
    {
        $this->expectException(ValidationException::class);
        $this->stub->str2 = "To cut corners";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox('Should throw ValidationException with custom message')]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("No bullets please!");
        $this->stub->str3 = "Bite the bullet";
        $this->stub->validate();
    }
}
