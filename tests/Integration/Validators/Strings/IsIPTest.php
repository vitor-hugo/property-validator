<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Strings\Contracts\ValidIsIPContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group('Validators')]
#[Group('Strings')]
#[Group('IsIP')]
#[TestDox('IsIP - String Validator')]
class IsIPTest extends TestCase
{
    public ValidIsIPContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsIPContract;
    }

    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }

    #[TestDox("Should throw ValidationException when invalid V4 IP")]
    public function testShouldThrowOnV4()
    {
        $this->expectException(ValidationException::class);
        $this->stub->ip4 = "fe80::a6db:30ff:fe98:e946";
        $this->stub->validate();
    }

    #[TestDox("Should throw ValidationException when invalid V6 IP")]
    public function testShouldThrowOnV6()
    {
        $this->expectException(ValidationException::class);
        $this->stub->ip6 = "192.168.0.13";
        $this->stub->validate();
    }

    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowValidationErrorWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid IP address!!!");
        $this->stub->ipAddress = "256.0.0.0";
        $this->stub->validate();
    }
}
