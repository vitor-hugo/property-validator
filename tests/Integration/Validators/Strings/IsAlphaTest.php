<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidIsAlphaContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("IsAlpha")]
#[TestDox("IsAlpha")]
class IsAlphaTest extends TestCase
{
    public ValidIsAlphaContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsAlphaContract;
    }


    #[TestDox("Should be valid alphabetic characters with or without unicode enabled")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("When 'includeUnicode' is enabled, should accept other kind of alphabetic chars")]
    public function testShouldBeValidWithUnicodeEnalbed()
    {
        $this->stub->str2 = 'ãáàâäçéêëíïõóôöúüÃÁÀÂÄÇÉÊËÍÏÕÓÔÖÚÜ';
        $this->assertTrue($this->stub->validate());

        $this->stub->str2 = '発達';
        $this->assertTrue($this->stub->validate());

        $this->stub->str2 = 'ανάπτυξη';
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException on non alphabetic chars")]
    public function testShouldThrowOnNonAlphabetical()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'str1' can only have alphabetical characters");
        $this->stub->str1 = "Apollo11";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Only alphabetic characters");
        $this->stub->str3 = "58ZYSPDgo9gRjGuieKdH6S";
        $this->stub->validate();
    }
}
