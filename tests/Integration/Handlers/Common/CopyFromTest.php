<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Common;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Common\Contracts\InvalidCopyFromContract;
use Tests\Integration\Handlers\Common\Contracts\ValidCopyFromContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;

#[Group("Common")]
#[Group("CopyFrom")]
#[TestDox("CopyFrom")]
class CopyFromTest extends TestCase
{
    public ValidCopyFromContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidCopyFromContract;
    }


    #[TestDox("Should copy value from target")]
    public function testShouldCopyValueFromTarget()
    {
        $this->stub->target = "Target Value";
        $this->stub->validate();

        $this->assertEquals($this->stub->target, $this->stub->copy);
    }

    #[TestDox("Should throw InvalidArgumentException on invalid value type")]
    public function testShouldThrowOnInvalidValueType()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'copy' must be setted as mixed or int.");
        $this->stub->target = 100;
        $this->stub->validate();
    }

    #[TestDox("Should throw InvalidArgumentException when target property does not exists")]
    public function testShouldThrowWhenTargetPropertyDoesNotExists()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Property 'target' does not exist on 'InvalidCopyFromContract' class.");
        $stub = new InvalidCopyFromContract();
        $stub->validate();
    }
}
