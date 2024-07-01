<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidIsAlphanumericContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('IsAlphanumeric')]
#[TestDox('IsAlphanumeric - String Validator')]
class IsAlphanumericTest extends TestCase
{
    public ValidIsAlphanumericContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsAlphanumericContract;
    }


    #[TestDox("Should be valid alphanumeric characters with or without unicode enabled")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("When 'includeUnicode' is enabled, should accept other kind of alphanumeric chars")]
    public function testShouldBeValidWithUnicodeEnalbed()
    {
        $this->stub->str2 = 'ãáàâäçéêëíïõóôöúüÃÁÀÂÄÇÉÊËÍÏÕÓÔÖÚÜ';
        $this->assertTrue($this->stub->validate());

        $this->stub->str2 = '発達';
        $this->assertTrue($this->stub->validate());

        $this->stub->str2 = 'ανάπτυξη';
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException on non alphanumeric chars")]
    public function testShouldThrowOnNonAlphabetical()
    {
        $expectedMessage = "Property 'str1' can only have alphanumeric characters.";
        $invalidValues = [
            "email@host.com",
            "no spabes allowed",
            "A1B2C3D4E5",
        ];

        foreach ($invalidValues as $value) {
            try {
                $this->stub->str1 = $value;
                $this->stub->validate();
            } catch (ValidationException $ve) {
                $this->assertEquals($expectedMessage, $ve->getMessage());
            } catch (\Throwable $th) {
                $this->fail("Failed asserting that ValidationException was thrown");
            }
        }

    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Only alphanumeric characters");
        $this->stub->str3 = "www.php.net";
        $this->stub->validate();
    }
}
