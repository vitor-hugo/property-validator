<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidPrependContract;

#[Group("Handlers")]
#[Group("Strings")]
#[Group("Prepend")]
#[TestDox("Prepend(): Handler")]
class PrependTest extends TestCase
{
    public ValidPrependContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidPrependContract;
    }


    #[TestDox("Should prepend on string, int or float")]
    public function testShouldConvertStrings()
    {
        $this->stub->item = "and counting";
        $this->stub->validate();
        $this->assertEquals("1 2 3 4 and counting", $this->stub->item);


        $this->stub->item = 56789;
        $this->stub->validate();
        $this->assertEquals("1 2 3 4 56789", $this->stub->item);

        $this->stub->item = 5.6789;
        $this->stub->validate();
        $this->assertEquals("1 2 3 4 5.6789", $this->stub->item);
    }


    #[TestDox("Should do nothing on invalid value types")]
    public function testShouldThrowOnNonStrings()
    {
        $this->stub->item = [1000];
        $this->assertTrue($this->stub->validate());
        $this->assertEquals([1000], $this->stub->item);
    }
}
