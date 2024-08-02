<?php declare(strict_types=1);

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Handlers\Setters\Contracts\ValidSetDateTimeContract;

#[Group("Setters")]
#[Group("SetDateTime")]
#[TestDox("SetDateTime")]
class SetDateTimeTest extends TestCase
{
    public ValidSetDateTimeContract $stub;

    public function setUp(): void
    {
        $this->stub = new ValidSetDateTimeContract();
    }


    #[TestDox("Should set the values correctly")]
    public function testShouldSetValuesCorrectly()
    {
        $this->stub = new ValidSetDateTimeContract();
        $this->assertTrue($this->stub->validate());
        $this->assertNotEmpty($this->stub->dt1);
    }
}
