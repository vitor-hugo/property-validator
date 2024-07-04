<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidReplaceContract;

#[Group("Strings")]
#[Group("Replace")]
#[TestDox("Replace")]
class ReplaceTest extends TestCase
{
    public ValidReplaceContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidReplaceContract;
    }


    #[TestDox("Should replace single string")]
    public function testShouldReplaceSingleString()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("Underscore_on_spaces", $this->stub->under);
        $this->assertEquals("2001:0000:130F:0000:0000:09C0:876A:130B", $this->stub->ipv6);
    }


    #[TestDox("Should replace using array arguments")]
    public function testShouldReplaceUsingArrayArgs()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("Vh9yB-XNo0cXfyfATY_bmw", $this->stub->b64);
    }


    #[TestDox("Should perform replace in cascade")]
    public function testShouldPerformReplaceInCascade()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("E", $this->stub->cascade);
    }


    #[TestDox("Sould replace string values in array")]
    public function testShouldReplaceStringValuesInArray()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals(["A", "B", "C", "D"], $this->stub->array);
    }
}
