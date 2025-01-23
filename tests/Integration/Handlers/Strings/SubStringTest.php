<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidSubStringContract;

#[Group("Strings")]
#[Group("SubString")]
#[TestDox("SubString")]
class SubStringTest extends TestCase
{
    public ValidSubStringContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidSubStringContract;
    }


    #[TestDox("Should return first 3 characters")]
    public function testShouldReturnFirst3Chars()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("abc", $this->stub->var1);
    }

    #[TestDox("Should return the last character")]
    public function testShouldReturnLastChar()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("f", $this->stub->var2);
    }

    #[TestDox("Should ignore the last character")]
    public function testShouldIgnoreTheLastCharacter()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("abcde", $this->stub->var3);
    }

    #[TestDox("Should return an empty string")]
    public function testShouldReturnAnEmptyString()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("", $this->stub->var4);
    }
}
