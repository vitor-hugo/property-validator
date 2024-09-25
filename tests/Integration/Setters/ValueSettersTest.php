<?php declare(strict_types=1);

namespace Tests\Integration\Setters;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Setters\Contracts\ValidSetValuesContract;

#[Group("Setters")]
#[Group("SetValueWhenNull")]
#[TestDox("SetDateTime")]
class ValueSettersTest extends TestCase
{
    public ValidSetValuesContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidSetValuesContract();
    }


    #[TestDox("Should set the values correctly")]
    public function testShouldSetValuesCorrectly()
    {
        $this->stub = new ValidSetValuesContract();
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("string", $this->stub->var1);
        $this->assertEquals(13, $this->stub->var2);
        $this->assertEquals(["a", "b"], $this->stub->var3);
    }
}
