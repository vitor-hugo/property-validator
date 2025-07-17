<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidRegexReplaceContract;

#[Group("Strings")]
#[Group("RegexReplace")]
#[TestDox("Regex Replace")]
class RegexReplaceTest extends TestCase
{
    public ValidRegexReplaceContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidRegexReplaceContract;
    }


    #[TestDox("Should replace regular expression")]
    public function testShouldReplaceRegularExpression()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("Should normalize consecutive spaces", $this->stub->doubleSpaces);
        $this->assertEquals("12345678910", $this->stub->onlyNumbers);
        $this->assertEquals("ABC-123", $this->stub->groups);
    }
}
