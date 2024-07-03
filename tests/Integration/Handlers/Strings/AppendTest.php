<?php declare(strict_types=1);

namespace Tests\Integration\Handlers\Strings;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Strings\Contracts\ValidAppendContract;

#[Group("Handlers")]
#[Group("Strings")]
#[Group("Append")]
#[TestDox("Append(): Handler")]
class AppendTest extends TestCase
{
    public ValidAppendContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidAppendContract;
    }


    #[TestDox("Should append on string, int or float")]
    public function testShouldConvertStrings()
    {
        $this->stub->item = "My String";
        $this->stub->validate();
        $this->assertEquals("My String>]})", $this->stub->item);


        $this->stub->item = 1234;
        $this->stub->validate();
        $this->assertEquals("1234>]})", $this->stub->item);

        $this->stub->item = 3.1415;
        $this->stub->validate();
        $this->assertEquals("3.1415>]})", $this->stub->item);
    }


    #[TestDox("Should do nothing on invalid value types")]
    public function testShouldThrowOnNonStrings()
    {
        $this->stub->item = [1000];
        $this->assertTrue($this->stub->validate());
        $this->assertEquals([1000], $this->stub->item);
    }
}
