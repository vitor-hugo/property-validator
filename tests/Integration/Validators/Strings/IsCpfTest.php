<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidIsCpfContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('IsCpf')]
#[TestDox('IsCpf - String Validator')]
class IsCpfTest extends TestCase
{
    public ValidIsCpfContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsCpfContract;
    }

    #[TestDox('Should be valid')]
    public function testShouldBeValid()
    {
        $this->stub->cpf = "532.625.750-54";
        $this->stub->ohterCpf = "88479747048";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should remove non numeric characters")]
    public function testShouldRemoveNonNumericCharacters()
    {
        $this->stub->cpf = "532 625 750 (54)";
        $this->stub->ohterCpf = "884:797:470:48";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when verification digit is invalid")]
    public function testShouldThrowWhenVerificationDigitIsInvalid()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The CPF '532.625.750-55' is not valid.");
        $this->stub->cpf = "532.625.750-55";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException on invalid length")]
    public function testShouldThrowOnInvalidLength()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The CPF '884797470483' is not valid.");
        $this->stub->cpf = "884797470483";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid CPF!!!");
        $this->stub->ohterCpf = "603916820001321";
        $this->stub->validate();
    }
}
