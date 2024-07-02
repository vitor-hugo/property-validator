<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Arrays\Contracts\ValidArrayKeyExistsContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Arrays")]
#[Group("ArrayKeyExists")]
#[TestDox("ArrayKeyExists(): Validator")]
class ArrayKeyExistsTest extends TestCase
{
    public ValidArrayKeyExistsContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidArrayKeyExistsContract;
    }


    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when key not found")]
    public function testShouldThrowWhenArrayHasNoKeys()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Key 'lastName' not found on 'arr1'.");
        $this->stub->arr1 = ["firstName" => "Luke"];
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when case sensitive is enabled")]
    public function testShouldThrowWhenCaseSensitiveIsEnalbed()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Key 'firstName' not found on 'arr1'.");
        $this->stub->arr1 = ["FIRSTNAME" => "Luke", "LASTNAME" => "Skywalker"];
        $this->stub->validate();
    }


    #[TestDox("Should be valid when case sensitive is disabled")]
    public function testShouldBeValidWhenCaseSensitiveIsDisabled()
    {
        $this->stub->arr2 = ["FIRSTNAME" => "Luke", "LASTNAME" => "Skywalker"];
        $this->assertTrue($this->stub->validate());
    }
}
