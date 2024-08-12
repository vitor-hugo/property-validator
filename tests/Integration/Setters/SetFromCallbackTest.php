<?php declare(strict_types=1);

namespace Tests\Integration\Setters;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Setters\Contracts\ValidSetFromCallbackContract;

#[Group("Setters")]
#[Group("SetFromCallback")]
#[TestDox("SetFromCallback")]
class SetFromCallbackTest extends TestCase
{
    public ValidSetFromCallbackContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidSetFromCallbackContract;
    }


    #[TestDox("Should set values from callbacks")]
    public function testShouldSetValuesFromCallback()
    {
        $this->assertTrue($this->stub->validate());
        $this->assertEquals(25, $this->stub->sum);
        $this->assertEquals("my string", $this->stub->str);
        $this->assertTrue($this->stub->random >= 10 && $this->stub->random <= 50);
    }
}
