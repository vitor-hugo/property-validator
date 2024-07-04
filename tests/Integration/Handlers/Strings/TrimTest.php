<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidTrimContract;

#[Group("Strings")]
#[Group("Trim")]
#[TestDox("Trim")]
class TrimTest extends TestCase
{
    public ValidTrimContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidTrimContract;
    }


    #[TestDox("Should trim whitespaces")]
    public function testShouldTrimWhitespaces()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("String", $this->stub->default);
    }


    #[TestDox("Should trim especific characters")]
    public function testShouldTrimEspeificCharacters()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("String", $this->stub->especific);
    }


    #[TestDox("Should trim character range")]
    public function testShouldTrimCharacterRange()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("FGF", $this->stub->range);
    }


    #[TestDox("Should do nothing on non strings")]
    public function testShouldDoNothingOnNonString()
    {
        $this->stub->default = ["  array   "];
        $this->assertTrue($this->stub->validate());
        $this->assertEquals(["  array   "], $this->stub->default);
    }
}
