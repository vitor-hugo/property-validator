<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Convertions;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Convertions\Contracts\InvalidJoinContract;
use Tests\Integration\Handlers\Convertions\Contracts\ValidJoinContract;
use Torugo\PropertyValidator\Exceptions\InvalidTypeException;

#[Group("Convertion")]
#[Group("Join")]
#[Group("Implode")]
#[TestDox("Join")]
class JoinTest extends TestCase
{
    public ValidJoinContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidJoinContract;
    }

    #[TestDox("Should Join/Implode with default separator")]
    public function testShouldJoinWithDefaultSeparator()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("ABCDEF", $this->stub->alpha);
    }


    #[TestDox("Should Join/Implode with custom separator")]
    public function testShouldJoinWithCustomSeparator()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("123.456.789.001", $this->stub->ip);
    }


    #[TestDox("Should Join/Implode Key=>Pair arrays")]
    public function testShouldJoinKeyPairArrays()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("Conceição Evaristo", $this->stub->name);
    }


    #[TestDox("Should Join/Implode including keys")]
    public function testShouldJoinWithKeys()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("firstName: Conceição - lastName: Evaristo", $this->stub->form);
    }


    #[TestDox("Should throw InvalidTypeException when property is not mixed type")]
    public function testShouldThrowWhenPropIsNotMixedType()
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage("Property 'alpha' must be setted as mixed.");
        $stub = new InvalidJoinContract;
        $stub->validate();
    }
}
