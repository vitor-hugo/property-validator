<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidContainsContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('Contains')]
#[TestDox('Contains - String Validator')]
class ContainsTest extends TestCase
{
    public ValidContainsContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidContainsContract;
    }

    #[TestDox('Should be valid when the value is found')]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox('Should throw ValidationException when the value is not found')]
    public function testShouldThrowWhenNotFound()
    {
        $this->expectException(ValidationException::class);
        $this->stub->str1 = "Look at the sky";
        $this->stub->validate();
    }


    #[TestDox('Should be valid with case sensitiveness disabled')]
    public function testShouldBeValidWithCaseSensitivenessDisabled()
    {
        $this->stub->str2 = "WHEN PIGS FLY";
        $this->stub->str3 = "CATS IN THE CRADLE";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox('Should throw ValidationException with case sensitiveness enabled')]
    public function testShouldThrowWithCaseSensitivenessEnabled()
    {
        $this->expectException(ValidationException::class);
        $this->stub->str1 = "SEE EYE TO EYE";
        $this->stub->validate();
    }


    #[TestDox('Should throw ValidationException with custom message')]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->stub->str3 = "X";
        $this->stub->validate();
    }
}
