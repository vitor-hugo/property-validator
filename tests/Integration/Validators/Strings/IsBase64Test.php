<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidIsBase64Contract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('IsBase64')]
#[TestDox('IsBase64 - String Validator')]
class IsBase64Test extends TestCase
{
    public ValidIsBase64Contract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsBase64Contract;
    }


    #[TestDox("Should be valid URL unsafe")]
    public function testShouldBeValidUrlUnsafe()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should be valid URL safe")]
    public function testShouldBeValidUrlSafe()
    {
        $this->stub->str1 = "vCA-bc7_jQok5yWlmgJm8g==";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should validate with right padding")]
    public function testShouldBeValidWithRightPadding()
    {
        // lga+Ib63szp3FPkC2ce3QQ==
        $this->stub->str1 = "lga-Ib63szp3FPkC2ce3QQ";
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException on invalid Base64 strings")]
    public function testShouldBeInvalid()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid Base64 string value on property 'str1'.");
        $this->stub->str1 = "FKgLuXN\qsxYnEgtyzKyxQ==";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowValidationErrorWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid Base64!!!");
        $this->stub->str2 = "vCA+bc7\jQok5yWlmgJm8g==";
        $this->stub->validate();
    }
}
