<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Common;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Common\Contracts\InvalidIsRequiredContract;
use Tests\Integration\Validators\Common\Contracts\ValidIsRequiredContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Common")]
#[Group("IsRequired")]
#[TestDox("IsRequired Validator")]
class IsRequiredTest extends TestCase
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
        $this->expectExceptionMessage("Property 'string' is required.");
        $this->stub->string = "";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when required property is NULL")]
    public function testShouldThrowWhenRequiredIsNull()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'mixed' can't be null.");
        $this->stub->mixed = null;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom error message")]
    public function testShouldThrowWithCustomErrorMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Password is required!");
        $this->stub->password = "";
        $this->stub->validate();
    }
}
