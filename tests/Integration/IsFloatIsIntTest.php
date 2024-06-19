<?php declare(strict_types=1);

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Contracts\ValidIsFloatIsIntContract;
use Tests\Integration\Contracts\ValidIsNumberContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Validators")]
#[Group("TypeCheckers")]
#[Group("IsFloat")]
#[Group("IsInt")]
#[TestDox("IsFloat / IsInt Validators")]
class IsFloatIsIntTest extends TestCase
{
    private ValidIsFloatIsIntContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidIsFloatIsIntContract;
    }


    #[TestDox("FLOAT and INT values should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("IsFloat(): Should throw ValidationException when value is not a FLOAT")]
    public function testShouldThrowWhenValueIsNotAFloat()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'float3' must receive float values, array received.");
        $this->stub->float3 = [9.99];
        $this->stub->validate();
    }


    #[TestDox("IsFloat(): Should throw ValidationException with a custom message")]
    public function testIsFloatShouldThroWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid float number!!!");
        $this->stub->float4 = ["array"];
        $this->stub->validate();
    }


    #[TestDox("IsInt(): Should throw ValidationException when value is not a INT")]
    public function testShouldThrowWhenValueIsNotAInt()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Property 'int3' must receive int values, float received.");
        $this->stub->int3 = 9.99;
        $this->stub->validate();
    }


    #[TestDox("IsInt(): Should throw ValidationException with a custom message")]
    public function testIsIntShouldThroWithCustomMessage()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("Invalid integer number!!!");
        $this->stub->int4 = ["array"];
        $this->stub->validate();
    }
}
