<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidIsCnpjContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('IsCnpj')]
#[TestDox('IsCnpj - String Validator')]
class IsCnpjTest extends TestCase
{
    public ValidIsCnpjContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsCnpjContract;
    }

    #[TestDox('Should be valid')]
    public function testShouldBeValid()
    {
        $this->stub->cnpj = "99.453.669/0001-04";
        $this->stub->ohterCnpj = "60391682000132";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should remove non numeric characters")]
    public function testShouldRemoveNonNumericCharacters()
    {
        $this->stub->cnpj = "99 453 669 0001 (04)";
        $this->stub->ohterCnpj = "60:391:682:0001:32";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when verification digit is invalid")]
    public function testShouldThrowWhenVerificationDigitIsInvalid()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The CNPJ '99.453.669/0001-05' is not valid.");
        $this->stub->cnpj = "99.453.669/0001-05";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException on invalid length")]
    public function testShouldThrowOnInvalidLength()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The CNPJ '603916820001321' is not valid.");
        $this->stub->cnpj = "603916820001321";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid CNPJ!!!");
        $this->stub->ohterCnpj = "603916820001321";
        $this->stub->validate();
    }
}
