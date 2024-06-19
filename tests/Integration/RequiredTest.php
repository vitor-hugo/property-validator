<?php declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Contracts\InvalidIsRequiredContract;
use Tests\Integration\Contracts\ValidIsRequiredContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Common")]
#[TestDox("IsRequired Validator")]
class RequiredTest extends TestCase
{
    private ValidIsRequiredContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsRequiredContract;
    }

    public function testShouldBeValid()
    {
        $this->stub->validate();
        $this->assertEquals("My String", $this->stub->string);
        $this->assertEquals(["mixed", "type"], $this->stub->mixed);
        $this->assertEquals("MySuperStrongPassword!", $this->stub->password);
    }


    #[TestDox("Should throw ValidationException when required property is empty")]
    public function testShouldThrowWhenRequiredIsEmpty()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The property 'string' is required.");
        $this->stub->string = '';
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when required property is NULL")]
    public function testShouldThrowWhenRequiredIsNull()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The property 'mixed' is required.");
        $this->stub->mixed = null;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when property is setted to nullable")]
    public function testShouldThrowWhenPropertyIsDefinedAsOptional()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The property 'string' cannot be REQUIRED and NULLABLE at the same time.");
        $stub = new InvalidIsRequiredContract();
        $stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom error message")]
    public function testShouldThrowWithCustomErrorMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Password is required!");
        $this->stub->password = '';
        $this->stub->validate();
    }
}
