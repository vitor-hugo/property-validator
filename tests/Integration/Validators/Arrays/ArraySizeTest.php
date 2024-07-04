<?php declare(strict_types=1);

namespace Tests\Integration\Validators\Arrays;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Validators\Arrays\Contracts\InvalidArrayMaxSizeContract;
use Tests\Integration\Validators\Arrays\Contracts\InvalidArrayMinSizeContract;
use Tests\Integration\Validators\Arrays\Contracts\ValidArraySizeContract;
use Torugo\PropertyValidator\Exceptions\ValidationException;

#[Group("Arrays")]
#[Group("ArrayMaxSize")]
#[Group("ArrayMinSize")]
#[Group("ArraySize")]
#[TestDox("ArraySize")]
class ArraySizeTest extends TestCase
{
    public ValidArraySizeContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidArraySizeContract;
    }


    #[TestDox("Should be valid")]
    public function testShouldBeValid()
    {
        $this->assertTrue($this->stub->validate());
    }


    #[TestDox("Should throw ValidationException when greater than MAX")]
    public function testShouldThrowWhenGreaterThanMax()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The number of elements on 'arr1' should be <= 3, 4 received.");
        array_push($this->stub->arr1, "D");
        $this->stub->validate();
    }


    #[TestDox("Should throw ValidationException when lesser than MIN")]
    public function testShouldThrowWhenLesserThanMin()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("The number of elements on 'arr2' should be >= 2, 1 received.");
        $this->stub->arr2 = ["A"];
        $this->stub->validate();
    }


    #[TestDox("Should Throw ValidationException when MAX arg is < 1")]
    public function testShouldThrowWhenMaxIsInvalid()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("ArrayMaxSize: the max argument must be >= 1.");
        $stub = new InvalidArrayMaxSizeContract;
        $stub->validate();
    }


    #[TestDox("Should Throw ValidationException when MIN arg is < 1")]
    public function testShouldThrowWhenMinIsInvalid()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage("ArrayMinSize: The min argument must be >= 1.");
        $stub = new InvalidArrayMinSizeContract;
        $stub->validate();
    }
}
