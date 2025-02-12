<?php declare(strict_types=1);

namespace Tests\Integration\Setters;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Setters\Contracts\ValidSetValueWhenEmptyContract;

#[Group("Setters")]
#[Group("SetValueWhenEmpty")]
#[TestDox("SetValueWhenEmpty")]
class SetValueWhenEmptyTest extends TestCase
{
    public ValidSetValueWhenEmptyContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidSetValueWhenEmptyContract();
    }

    #[TestDox("Should set the values correctly")]
    public function testShouldSetValuesCorrectly()
    {
        $this->stub = new ValidSetValueWhenEmptyContract();
        $this->assertTrue($this->stub->validate());

        $this->assertEquals("default", $this->stub->var1);

        $this->assertEquals("default", $this->stub->var2);

        $this->assertEquals("mixed", $this->stub->var3);
    }
}
