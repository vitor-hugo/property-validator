<?php declare(strict_types=1);

namespace Tests\Integration\Order;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Tests\Integration\Order\Contracts\OrderContract;

#[Group("Handlers")]
#[Group("Order")]
#[TestDox("Execution Order")]
class ExecutionOrderTest extends TestCase
{
    public OrderContract $stub;

    public function setUp(): void
    {
        $this->stub = new OrderContract;
    }


    #[TestDox("Should resolve attributes in the order they were defined")]
    public function testShouldExecuteInTheCorrectOrder()
    {
        $this->stub->email = "JHON.APPLESEED@APPLE.COM";
        $this->assertTrue($this->stub->validate());
        $this->assertEquals("mailto:jhon.appleseed@apple.com;", $this->stub->email);
    }
}
