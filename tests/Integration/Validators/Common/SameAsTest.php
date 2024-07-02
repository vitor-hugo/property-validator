<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Common;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Common\Contracts\InvalidSameAsContract;
use Tests\Integration\Validators\Common\Contracts\ValidSameAsContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("Common")]
#[Group("SameAs")]
#[TestDox("SameAs(): Validator")]
class SameAsTest extends TestCase
{
    private ValidSameAsContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidSameAsContract();
    }

    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $testValues = [
            "String Test",
            -512,
            2056,
            -9.99,
            3.1415,
            ["A", "B"],
            true,
            false,
            null,
        ];

        foreach ($testValues as $value) {
            $this->stub->propA = $value;
            $this->stub->propB = $value;
            $this->assertTrue($this->stub->validate());
        }
    }


    #[TestDox("Should throw ValidationException when valies is different")]
    public function testShouldThrowWhenDifferent()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The value of 'propB' is different from 'propA'.");
        $this->stub->propA = "BahBbRRm5v4u5yOh";
        $this->stub->propB = "Mt5ADkOxSj4CH+FO";
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when values is not strict equal")]
    public function testShouldThrowWhenNotStrictEqual()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The value of 'propB' is different from 'propA'.");
        $this->stub->propA = "256";
        $this->stub->propB = 256;
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException with custom message")]
    public function testShouldThrowWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Not equal!!!");
        $this->stub->propC = ["A", "B"];
        $this->stub->propD = ["A", "B", "C"];
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when target property not exist")]
    public function testShouldThrowWhenPropNotExist()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'propC' does not exist on 'InvalidSameAsContract' class.");
        $stub = new InvalidSameAsContract;
        $stub->validate();
    }
}
